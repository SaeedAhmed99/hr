<template>
    <div class="card mt-4" id="list-item-4">
        <div class="card-header">Email notification</div>
        <div class="card-body">
            <table class="table dataTable-table" id="pc-dt-simple">
                <thead>
                    <tr>
                        <th class="w-75" data-sortable="" style="width: 74.9565%"><a href="#" class="dataTable-sorter"> Name</a></th>
                        <th class="text-center" data-sortable="" style="width: 24.939%"><a href="#" class="dataTable-sorter"> On/Off</a></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td>Create User</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="1"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/1"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Employee Create</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="2"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/2"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Payroll Create</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="3"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/3"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Ticket Create</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="4"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/4"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Award Create</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="5"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/5"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Employee Transfer</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="6"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/6"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Employee Resignation</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="7"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/7"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Employee Trip</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="8"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/8"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Employee Promotion</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="9"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/9"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td>Employee Complaints</td>
                        <td class="text-center">
                            <div class="form-group col-md-12">
                                <label class="form-check form-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="email-template-checkbox form-check-input"
                                        name="10"
                                        :checked="false"
                                        value="1"
                                        data-url="https://hrpayroll.codecloudtech.com/company-email-setting/10"
                                    />
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>