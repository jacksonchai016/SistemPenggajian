<?php
    $role_list = array('hr'=> "HR", "bpjs_hr"=> "BJPS HR", "payroll"=> "Payroll");
?>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Nama' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="email" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    <label for="role" class="control-label">{{ 'Employee' }}</label>
    <select required name="role" class="form-control" id="role" >
        @foreach ($role_list as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($user->role) && $user->role == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
