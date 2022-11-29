<?php
    use App\Models\Employee;

    use Illuminate\Support\Facades\DB; 

    $employees = Employee::all();

    $employee_data = array();

    foreach ($employees as $employee) {
        $employee_data[$employee->id] = $employee->name;
    }

    $employee_data = array('' => 'Select Employee') + $employee_data;

    $json_data = json_encode($employee_data);

    function checkView($employee_id)
    {
        #This function is used to check if view is exist or not
        #If exist, return the view else, create the view and return the view

        $employeeContractView = contract::searchView($employee_id);
        if ($employeeContractView == false){
            contract::createView();
            $employeeContractView = contract::searchView($employee_id);
        }
        return $employeeContractView;
    }

    function createView(){
        #Create view function
        $sql = '
        CREATE VIEW employee_contract_view as
            SELECT
                employees.id as employee_id,
                employees.name as employee_name,
                contracts.id as contract_id,
                contracts.currency as currency,
                COALESCE(contracts.wages, 0) as wages,
                COALESCE(contracts.pph21, 0) as pph21,
                COALESCE(contracts.food, 0) as food,
                COALESCE(contracts.transport,0) as transport,
                COALESCE(contracts.work_day,0) as work_day,
                COALESCE(bpjs.cost,0) as bpjs_cost
            FROM employees
            LEFT JOIN contracts ON employees.contract_id = contracts.id
            LEFT JOIN bpjs_datas bpjs ON contracts.bpjs_category_id = bpjs.id
            WHERE contracts.active = 1 AND bpjs.active = 1
        ';
        DB::query($sql);
    }

    function searchView($employee_id)
    {
        try{
            $view = DB::select('SELECT * FROM employee_contract_view where employee_id = ?', [$employee_id]);
            return $view;
        }
        catch(Exception $e){
            return false;
        }
    }

    function getTotalWorkDays($employee_id,$date_from, $date_to){
        $query = "
            SELECT COALESCE(COUNT(a.in_time),0) as total_attendance
            FROM employees
            LEFT JOIN attendances a on employees.id = a.employee_id
            WHERE a.in_time BETWEEN '?' AND '?' AND employees.id = ?
        ";
        $totalWorkDays = DB::select($query, [$date_from, $date_to, $employee_id]);
        return $totalWorkDays[0]->total_attendance;
    }

    function onchangeEmployee($employee_id, $date_from, $date_to){
        # if employee change, compute wages, pph21, bpjs, etc
        $employeeContractView = contract::checkView($employee_id);
        $total_work_days = contract::getTotalWorkDays($employee_id,$date_from, $date_to);
        $contractView = $employeeContractView[0];
        $earned_data = contract::getEarnedData($contractView, $total_work_days);
        return $earned_data;
    }

    function getEarnedData($contractView, $total_work_days){
        #Function to get earned data in dict format
        $wages = $contractView->wages;
        $pph21 = $contractView->pph21;
        $food = $contractView->food;
        $transport = $contractView->transport;
        $work_day = $contractView->work_day;
        $bpjs_cost = $contractView->bpjs_cost;
        $wages_per_day = $wages / $work_day;
        $total_earned_wages = $wages_per_day * $total_work_days;
        $total_earned_contract = ($total_earned_wages + $food + $transport) - ($pph21 + $bpjs_cost);
        $earned_data = array(
            "currency" => $contractView->currency,
            "contract_id" => $contractView->contract_id,
            'wages' => $wages,
            'pph21' => $pph21,
            'food' => $food,
            'transport' => $transport,
            'work_day' => $total_work_days,
            'bpjs_cost' => $bpjs_cost,
            'wages_per_day' => $wages_per_day,
            'total_earned_wages' => $total_earned_wages,
            'total_earned_contract' => $total_earned_contract
        );
        return $earned_data;
    }

?>

<script>

    function onchangeEmployeeDate(){
        var employee_id = document.getElementById("employee_id").value;
        var date_from = document.getElementById("start_date").value;
        var date_to = document.getElementById("end_date").value;
        // Stuck disini
        // if (employee_id != '' && date_from != '' && date_to != '') {
        //     jQuery.ajax({
        //     type:'POST',
        //     url:'/admin/payslip/create',
        //     data: {action: 'onchangeEmployee', arguments: [employee_id, date_from, date_to]},
        //     success: function (obj, textstatus) {
        //         console.log(obj);
        //         if( !('error' in obj) ){
        //             insertData(obj);
        //         }
        //         else {
        //             console.log(obj.error);
        //         }
        //     }
        //     })
        // }
    }

    function insertData(obj){
        document.getElementById("currency_id").value = obj.currency;
        document.getElementById("currency").innerHtml = obj.currency;
        document.getElementById("contract_id").value = obj.contract_id;
        document.getElementById("basic_salary").innerHtml = obj.wages;
        document.getElementById("food").innerHtml = obj.food;
        document.getElementById("transport").innerHtml = obj.transport;
        document.getElementById("pph21").innerHtml = obj.pph21;
        document.getElementById("bpjs_kesehatan").innerHtml = obj.bpjs_kesehatan;
        document.getElementById("work_days").innerHtml = obj.work_day;
        document.getElementById("actual_wages").innerHtml = obj.total_earned_wages;
        document.getElementById("gross_salary").innerHtml = obj.total_earned_contract;
    }

</script>

<div class="form-group {{ $errors->has('employee_id') ? 'has-error' : ''}}">
    <label for="employee_id" class="control-label">{{ 'Employee Id' }}</label>
    <select onchange=onchangeEmployeeDate() required name="employee_id" class="form-control" id="employee_id" >
    @foreach (json_decode($json_data, true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($payslip->employee_id) && $payslip->employee_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
    {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
</div>
<div invisible class="form-group {{ $errors->has('contract_id') ? 'has-error' : ''}}">
    <label for="contract_id" class="control-label">{{ 'Contract Id' }}</label>
    <input class="form-control" name="contract_id" type="hidden" id="contract_id" value="{{ isset($payslip->contract_id) ? $payslip->contract_id : ''}}" >
    {!! $errors->first('contract_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('currency') ? 'has-error' : ''}}">
    <label for="currency" class="control-label">{{ 'Currency' }}</label>
    <input readonly class="form-control" name="currency" type="text" id="currency" value="{{ isset($payslip->currency) ? $payslip->currency : ''}}" >
    {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
    <label for="start_date" class="control-label">{{ 'Start Date' }}</label>
    <input onchange=onchangeEmployeeDate() class="form-control" name="start_date" type="date" id="start_date" value="{{ isset($payslip->start_date) ? $payslip->start_date : ''}}" >
    {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
    <label for="end_date" class="control-label">{{ 'End Date' }}</label>
    <input onchange=onchangeEmployeeDate() class="form-control" name="end_date" type="date" id="end_date" value="{{ isset($payslip->end_date) ? $payslip->end_date : ''}}" >
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

<table>
    <tr>
        <th>Type</th>
        <th>Amount</th>
    </tr>
    <tr>
        <th colspan="2">Base Amount</th>
    </tr>
    <tr>
        <td>Basic Salary</td>
        <td><b id="currency"></b> <b id="basic_salary">0</b></td>
    </tr>
    <tr>
        <td>Food</td>
        <td><b id="currency"></b> <b id="food">0</b></td>
    </tr>
    <tr>
        <td>Transport</td>
        <td><b id="currency"></b> <b id="transport">0</b></td>
    </tr>
    <tr>
        <th colspan="2">Deduction Amount</th>
    </tr>
    <tr>
        <td>PPh21</td>
        <td><b id="currency"></b> <b id="pph21">0</b></td>
    </tr>
    <tr>
        <td>BPJS Kesehatan</td>
        <td><b id="currency"></b> <b id="bpjs_kesehatan">0</b></td>
    </tr>
    <tr>
        <th class="2">Actual Earned</th>
    </tr>
    <tr>
        <td>Work Days</td>
        <td><b id="currency"></b> <b id="work_days">0</b></td>
    </tr>
    <tr>
        <td>Actual Wages</td>
        <td><b id="currency"></b> <b id="actual_wages">0</b></td>
    </tr>
    <tr>
        <th colspan="2">Total</th>
    </tr>
    <tr>
        <td>Gross Salary</td>
        <td><b id="currency"></b> <b id="gross_salary">0</b></td>
    </tr>
</table>

<div class="form-group {{ $errors->has('payslip_amount') ? 'has-error' : ''}}">
    <label for="payslip_amount" class="control-label">{{ 'Payslip Amount' }}</label>
    <input class="form-control" readonly name="payslip_amount" type="number" id="payslip_amount" value="{{ isset($payslip->payslip_amount) ? $payslip->payslip_amount : ''}}" >
    {!! $errors->first('payslip_amount', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
