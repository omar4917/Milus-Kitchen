@extends('layouts.admin')

@section('page_title', 'Manage Specials')

@section('content')
<div class="card card-form">
    <div class="card-header">
        <h4>Homepage Specials Section</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="specials_title">Section Title *</label>
                <input type="text" id="specials_title" name="specials_title" class="form-control" value="{{ \App\Models\Setting::get('specials_title', 'Holiday Specials') }}" required>
                <small class="form-text text-muted">e.g., "Holiday Specials", "Eid Specials", "Today's Specials"</small>
            </div>

            <div class="form-group">
                <label for="specials_subtitle">Section Subtitle</label>
                <input type="text" id="specials_subtitle" name="specials_subtitle" class="form-control" value="{{ \App\Models\Setting::get('specials_subtitle', 'Celebrate the season with our exclusive festive dishes') }}">
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary">Update Configuration</button>
            </div>
        </form>
    </div>
</div>
@endsection
