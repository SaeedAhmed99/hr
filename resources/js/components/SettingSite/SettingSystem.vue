<template>
    <div class="card mt-4" id="list-item-2">
        <div class="card-header">System Setting</div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="site_currency" class="col-form-label">Currency *</label>
                    <input class="form-control" name="site_currency" type="text" id="site_currency" />
                    <small class="text-xs">
                        Note: Add currency code as per three-letter ISO code.
                        <a href="https://stripe.com/docs/currencies" target="_blank">you can find out here..</a>
                    </small>
                </div>
                <div class="form-group col-md-4">
                    <label for="site_currency_symbol" class="col-form-label">Currency Symbol *</label>
                    <input class="form-control" name="site_currency_symbol" type="text" id="site_currency_symbol" />
                </div>
                <div class="form-group col-md-4">
                    <label class="col-form-label">Currency Symbol Position</label>
                    <div class="form-check form-check">
                        <input class="form-check-input" type="radio" id="pre" name="site_currency_symbol_position" :checked="false" />
                        <label class="form-check-label" for="pre"> Pre </label>
                    </div>
                    <div class="form-check form-check">
                        <input class="form-check-input" type="radio" id="post" name="site_currency_symbol_position" />
                        <label class="form-check-label" for="post"> Post </label>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="site_date_format" class="col-form-label">Date Format</label>
                    <select name="date_format" id="date_format" class="form-control">
                        <option value="">Select date format</option>
                        <option value="d-m-Y">31-01-2022</option>
                        <option value="M d, Y">Jan 31, 2022</option>
                        <option value="m-d-Y">01-31-2022</option>
                        <option value="Y-m-d">2022-01-31</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="site_time_format" class="col-form-label">Time Format</label>
                    <select name="date_format" id="date_format" class="form-control">
                        <option value="">Select date format</option>
                        <option value="d-m-Y">31-01-2022</option>
                        <option value="M d, Y">Jan 31, 2022</option>
                        <option value="m-d-Y">01-31-2022</option>
                        <option value="Y-m-d">2022-01-31</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="employee_prefix" class="col-form-label">Employee Prefix</label>
                    <input class="form-control" name="employee_prefix" type="text" id="employee_prefix" />
                </div>
            </div>
        </div>
    </div>
</template>