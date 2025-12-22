@extends('layouts.admin')

@section('title', 'Edit Coupon')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Coupon: {{ $coupon->code }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="code">Coupon Code *</label>
                            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required style="text-transform: uppercase;">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="type">Discount Type *</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="value">Discount Value *</label>
                                    <input type="number" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $coupon->value) }}" step="0.01" min="0" required>
                                    @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="min_order">Minimum Order Amount</label>
                                    <input type="number" name="min_order" id="min_order" class="form-control" value="{{ old('min_order', $coupon->min_order) }}" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="max_uses">Maximum Uses</label>
                                    <input type="number" name="max_uses" id="max_uses" class="form-control" value="{{ old('max_uses', $coupon->max_uses) }}" min="1">
                                    <small class="text-muted">Used: {{ $coupon->used_count }} times</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="starts_at">Valid From</label>
                                    <input type="datetime-local" name="starts_at" id="starts_at" class="form-control" value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d\TH:i')) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="expires_at">Valid Until</label>
                                    <input type="datetime-local" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Active</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Coupon</button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
