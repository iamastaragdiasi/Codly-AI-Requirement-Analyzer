@extends('layout')
@section('content')
<h1>{{ $project->name }}</h1><p>Revision {{ $project->revision }} · {{ $project->isApproved() ? 'Human approved for this revision' : 'Awaiting review / renewed approval' }}</p>
<section><h2>Project context</h2><form method="post" action="{{ route('projects.update',$project) }}">@csrf @method('PUT') <input type="hidden" name="revision" value="{{ $project->revision }}"> @include('project-fields')<button>Save context · invalidates approval</button></form></section>
@if(auth()->id()===$project->user_id)<section><h2>Assign authorized reviewer</h2><form method="post" action="{{ route('projects.reviewer',$project) }}">@csrf<label>Reviewer<select name="reviewer_id" required>@foreach($reviewers as $reviewer)<option value="{{ $reviewer->id }}" @selected($project->reviewer_id===$reviewer->id)>{{ $reviewer->name }}</option>@endforeach</select></label><button>Assign</button></form></section>@endif
<section><h2>Requirement or clarification intake</h2><p>Text, structured and clarification forms are supported. You can also upload a text-readable PDF or DOCX (maximum 10 MB and 50,000 extracted characters). Scanned/image-only PDFs, OCR, TXT uploads, audio, screenshots and website fetching are not supported. Original text is retained; sources start unconfirmed.</p>
<form method="post" action="{{ route('sources.store',$project) }}">@csrf
<label>Source kind<select name="kind"><option>text</option><option>structured</option><option>clarification</option></select></label>
<label>Original requirement / answer<textarea name="original" maxlength="50000" required>{{ old('original') }}</textarea></label>
<label>User role<input name="role" maxlength="200"></label><label>Feature<input name="feature" maxlength="500"></label>
<label>Priority<select name="priority">@foreach(['Must','Should','Could','Future'] as $priority)<option>{{ $priority }}</option>@endforeach</select></label>
<label>Source or question reference<input name="reference" maxlength="200"></label><button>Submit evidence</button></form>
<section>
<h3>Upload requirement document</h3>
<p>Upload a text-readable PDF or DOCX file. Maximum 10 MB and 50,000 extracted characters. Scanned PDFs and image-only documents are not supported. Extracted content is stored as unconfirmed source evidence.</p>
<form method="post" enctype="multipart/form-data" action="{{ route('sources.store', $project) }}">
@csrf
<input type="hidden" name="kind" value="document">
<label>Document file
<input type="file" name="file" accept=".pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
</label>
<label>User role <input name="role" maxlength="200"></label>
<label>Feature <input name="feature" maxlength="500"></label>
<label>Priority
<select name="priority">
<option>Must</option>
<option>Should</option>
<option>Could</option>
<option>Future</option>
</select>
</label>
<button type="submit">Upload and extract text</button>
@error('file')
<p role="alert">{{ $message }}</p>
@enderror
</form>
</section>
<details><summary>Original sources ({{ $project->sources->count() }})</summary>@foreach($project->sources as $source)<article><strong>Source #{{ $source->id }} · {{ $source->kind }} · by user #{{ $source->user_id }} · {{ $source->created_at }}</strong><pre>{{ $source->original }}</pre><p>{{ json_encode($source->metadata,JSON_UNESCAPED_UNICODE) }}</p></article>@endforeach</details></section>
<section><h2>Structured analysis</h2><form method="post" action="{{ route('analysis.store',$project) }}">@csrf<button>Generate local demo analysis · new revision</button></form>
@if($analysis)<p>{{ $analysis->provider }} · {{ $analysis->status }} · revision {{ $analysis->revision }} @if($analysis->revision!==$project->revision) · STALE — regenerate before approval @endif</p>
@foreach($analysis->failures as $module=>$failure)<p role="alert">{{ $module }}: {{ $failure }}</p>@endforeach
@foreach($analysis->results as $module=>$result)<details><summary>{{ str_replace('_',' ',$module) }} · {{ count($result['items']) }} findings</summary>
@if($module==='screens')<h3>Proposed screens grouped by role</h3>@foreach(collect($result['items'])->groupBy('role') as $role=>$screens)<section><h3>{{ $role }}</h3>@foreach($screens as $screen)<p>{{ $screen['title'] }} · {{ $screen['feature'] }} · {{ $screen['provenance'] }}</p>@endforeach</section>@endforeach @endif
@foreach($result['items'] as $index=>$item)<article><h3>{{ $item['title'] }}</h3><p>{{ $item['provenance'] }} · {{ $item['priority'] }} · {{ $item['scope'] }}</p><p>Role: {{ $item['role'] }} · Objective: {{ $item['objective'] }} · Feature: {{ $item['feature'] }}</p><p>Dependencies: {{ implode(', ',$item['dependencies']) }} · {{ $item['notes'] }}</p><p>Source IDs: {{ implode(', ',$item['source_ids']) }}</p><details><summary>Original statements</summary>@foreach($item['statements'] as $statement)<pre>{{ $statement }}</pre>@endforeach</details>
@can('review',$project)
@if($analysis->revision===$project->revision && $analysis->status==='complete')
<form method="post" action="{{ route('reviews.store',$project) }}">@csrf<input type="hidden" name="revision" value="{{ $project->revision }}"><input type="hidden" name="module" value="{{ $module }}"><input type="hidden" name="index" value="{{ $index }}">
<label>Finding<textarea name="title" required maxlength="1000">{{ $item['title'] }}</textarea></label>
<label>Scope<select name="scope">@foreach(['included','excluded','assumption','optional','unresolved'] as $scope)<option @selected($scope===$item['scope'])>{{ $scope }}</option>@endforeach</select></label>
<label>Priority<select name="priority">@foreach(['Must','Should','Could','Future'] as $priority)<option @selected($priority===$item['priority'])>{{ $priority }}</option>@endforeach</select></label>
@foreach(['role'=>'Role','objective'=>'Objective','feature'=>'Feature'] as $field=>$label)<label>{{ $label }}<textarea name="{{ $field }}" required>{{ $item[$field] }}</textarea></label>@endforeach
<label>Dependencies (comma separated)<input name="dependencies" value="{{ implode(', ',$item['dependencies']) }}" maxlength="2000"></label>
<label>Notes<textarea name="notes" required maxlength="2000">{{ $item['notes'] }}</textarea></label>
<label>Decision<select name="decision"><option>edited</option><option>rejected</option><option>resolved</option><option>client_confirmed</option></select></label><label>Client evidence (mandatory for explicit client confirmation)<textarea name="evidence" maxlength="2000"></textarea></label><button>Record review · new revision</button></form>
@endif @endcan
</article>@endforeach</details>@endforeach
@endif</section>
@can('review',$project)
<section><h2>Review exact revision {{ $project->revision }}</h2><p>Approval records human acceptance only. It never changes finding provenance. Check source evidence, unresolved questions and conflicts, scope boundaries, Future backlog, permissions, payment handling, dependencies, technical feasibility and commercial terms.</p><form method="post" action="{{ route('approvals.store',$project) }}">@csrf<input type="hidden" name="revision" value="{{ $project->revision }}"><label>Decision<select name="decision"><option>changes_requested</option><option>approved</option><option>rejected</option></select></label><label>Review notes<textarea name="notes" required maxlength="2000"></textarea></label><button>Record decision</button></form></section>
<section><h2>Proposal draft</h2><p>Current scope approval required. Drafting changes content and requires renewed revision approval. No prices or numeric effort are generated.</p><form method="post" action="{{ route('proposal.store',$project) }}">@csrf<input type="hidden" name="revision" value="{{ $project->revision }}"><label>Human-entered provisional effort hours (optional)<input name="effort_hours" type="number" min="0" step="0.5"></label><label>Estimate rationale<textarea name="estimate_notes" maxlength="2000"></textarea></label><label>Human-entered price (optional)<input name="price" type="number" min="0" step="0.01"></label><label>Currency<select name="currency"><option>INR</option><option>USD</option><option>EUR</option><option>GBP</option></select></label>@foreach(['maintenance'=>'Maintenance terms','third_party_costs'=>'Third-party costs and payer','client_responsibilities'=>'Client responsibilities'] as $field=>$label)<label>{{ $label }}<textarea name="{{ $field }}" required maxlength="5000"></textarea></label>@endforeach<button>Create draft</button></form></section>
@endcan
<section><h2>Revision and decision history</h2>@foreach($project->approvals as $approval)<p>Revision {{ $approval->revision }} · {{ $approval->decision }} · reviewer #{{ $approval->user_id }} · {{ $approval->created_at }} · {{ $approval->notes }}</p>@endforeach
@foreach($project->artifacts as $artifact)<details><summary>{{ $artifact->kind }} · revision {{ $artifact->revision }} · user #{{ $artifact->user_id }} · {{ $artifact->created_at }}</summary><pre>{{ json_encode($artifact->content,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre></details>@endforeach
@foreach($project->auditEvents as $event)<p>{{ $event->action }} · revision {{ $event->revision }} · user #{{ $event->user_id }} · {{ $event->created_at }}</p>@endforeach</section>
@endsection