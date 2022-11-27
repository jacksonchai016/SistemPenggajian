<div class="form-group {{ $errors->has('employee_id') ? 'has-error' : ''}}">
    <label for="employee_id" class="control-label">{{ 'Employee Id' }}</label>
    <input class="form-control" name="employee_id" type="number" id="employee_id" value="{{ isset($payslip->employee_id) ? $payslip->employee_id : ''}}" >
    {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('contract_id') ? 'has-error' : ''}}">
    <label for="contract_id" class="control-label">{{ 'Contract Id' }}</label>
    <input class="form-control" name="contract_id" type="number" id="contract_id" value="{{ isset($payslip->contract_id) ? $payslip->contract_id : ''}}" >
    {!! $errors->first('contract_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('currency') ? 'has-error' : ''}}">
    <label for="currency" class="control-label">{{ 'Currency' }}</label>
    <input class="form-control" name="currency" type="text" id="currency" value="{{ isset($payslip->currency) ? $payslip->currency : ''}}" >
    {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
    <label for="start_date" class="control-label">{{ 'Start Date' }}</label>
    <input class="form-control" name="start_date" type="date" id="start_date" value="{{ isset($payslip->start_date) ? $payslip->start_date : ''}}" >
    {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
    <label for="end_date" class="control-label">{{ 'End Date' }}</label>
    <input class="form-control" name="end_date" type="date" id="end_date" value="{{ isset($payslip->end_date) ? $payslip->end_date : ''}}" >
    {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('deduction') ? 'has-error' : ''}}">
    <label for="deduction" class="control-label">{{ 'Deduction' }}</label>
    <input class="form-control" name="deduction" type="number" id="deduction" value="{{ isset($payslip->deduction) ? $payslip->deduction : ''}}" >
    {!! $errors->first('deduction', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('bonus') ? 'has-error' : ''}}">
    <label for="bonus" class="control-label">{{ 'Bonus' }}</label>
    <input class="form-control" name="bonus" type="number" id="bonus" value="{{ isset($payslip->bonus) ? $payslip->bonus : ''}}" >
    {!! $errors->first('bonus', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payslip_amount') ? 'has-error' : ''}}">
    <label for="payslip_amount" class="control-label">{{ 'Payslip Amount' }}</label>
    <input class="form-control" name="payslip_amount" type="number" id="payslip_amount" value="{{ isset($payslip->payslip_amount) ? $payslip->payslip_amount : ''}}" >
    {!! $errors->first('payslip_amount', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
