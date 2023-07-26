<template>
    <div class="card" id="list-item-1">
        <div class="card-header">Company Setting</div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="company_name *" class="col-form-label">Company Name *</label>
                    <input class="form-control" placeholder="Enter yore company name" name="company_name" type="text" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_address" class="col-form-label">Address</label>
                    <input class="form-control" placeholder="Enter yore Address" name="company_address" type="text" id="company_address" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_city" class="col-form-label">City</label>
                    <input class="form-control" placeholder="Enter yore City" name="company_city" type="text" id="company_city" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_state" class="col-form-label">State</label>
                    <input class="form-control" placeholder="Enter yore State" name="company_state" type="text" id="company_state" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_zipcode" class="col-form-label">Zip/Post Code</label>
                    <input class="form-control" placeholder="Enter yore Zip/Post Code" name="company_zipcode" type="text" id="company_zipcode" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_country" class="col-form-label">Country</label>
                    <input class="form-control" placeholder="Enter yore Country" name="company_country" type="text" id="company_country" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_telephone" class="col-form-label">Telephone</label>
                    <input class="form-control" placeholder="Enter yore Telephone" name="company_telephone" type="text" id="company_telephone" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_email" class="col-form-label">System Email *</label>
                    <input class="form-control" placeholder="Enter yore System Email" name="company_email" type="text" id="company_email" />
                </div>
                <div class="form-group col-md-4">
                    <label for="company_email_from_name" class="col-form-label">Email (From Name) *</label>
                    <input class="form-control" placeholder="Enter yore Email" name="company_email_from_name" type="text" id="company_email_from_name" />
                </div>

                <div class="form-group col-md-6">
                    <label for="company_start_time" class="col-form-label">Company Start Time *</label>

                    <input class="form-control timepicker_format" name="company_start_time" type="time" id="company_start_time" />
                </div>
                <div class="form-group col-md-6">
                    <label for="company_end_time" class="col-form-label">Company End Time *</label>
                    <input class="form-control timepicker_format" name="company_end_time" type="time" id="company_end_time" />
                </div>

                <div class="form-group col-md-6">
                    <label for="timezone" class="col-form-label text-dark">Timezone</label>
                    <select class="form-control" name="timezone" id="timezone">
                        <option value="">Select timezone</option>
                        <option value="-12:00">(GMT -12:00) Eniwetok, Kwajalein</option>
                        <option value="-11:00">(GMT -11:00) Midway Island, Samoa</option>
                        <option value="-10:00">(GMT -10:00) Hawaii</option>
                        <option value="-09:50">(GMT -9:30) Taiohae</option>
                        <option value="-09:00">(GMT -9:00) Alaska</option>
                        <option value="-08:00">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
                        <option value="-07:00">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
                        <option value="-06:00">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
                        <option value="-05:00">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                        <option value="-04:50">(GMT -4:30) Caracas</option>
                        <option value="-04:00">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
                        <option value="-03:50">(GMT -3:30) Newfoundland</option>
                        <option value="-03:00">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                        <option value="-02:00">(GMT -2:00) Mid-Atlantic</option>
                        <option value="-01:00">(GMT -1:00) Azores, Cape Verde Islands</option>
                        <option value="+00:00">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
                        <option value="+01:00">(GMT +1:00) Brussels, Copenhagen, Madrid, Paris</option>
                        <option value="+02:00">(GMT +2:00) Kaliningrad, South Africa</option>
                        <option value="+03:00">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                        <option value="+03:50">(GMT +3:30) Tehran</option>
                        <option value="+04:00">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
                        <option value="+04:50">(GMT +4:30) Kabul</option>
                        <option value="+05:00">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                        <option value="+05:50">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
                        <option value="+05:75">(GMT +5:45) Kathmandu, Pokhara</option>
                        <option value="+06:00">(GMT +6:00) Almaty, Dhaka, Colombo</option>
                        <option value="+06:50">(GMT +6:30) Yangon, Mandalay</option>
                        <option value="+07:00">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                        <option value="+08:00">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                        <option value="+08:75">(GMT +8:45) Eucla</option>
                        <option value="+09:00">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                        <option value="+09:50">(GMT +9:30) Adelaide, Darwin</option>
                        <option value="+10:00">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                        <option value="+10:50">(GMT +10:30) Lord Howe Island</option>
                        <option value="+11:00">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                        <option value="+11:50">(GMT +11:30) Norfolk Island</option>
                        <option value="+12:00">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                        <option value="+12:75">(GMT +12:45) Chatham Islands</option>
                        <option value="+13:00">(GMT +13:00) Apia, Nukualofa</option>
                        <option value="+14:00">(GMT +14:00) Line Islands, Tokelau</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <input type="checkbox" class="form-check-input" data-toggle="switchbutton" data-onstyle="primary" name="ip_restrict" id="ip_restrict" />
                    <label class="col-form-label p-0" for="ip_restrict">Ip Restrict</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, onMounted } from 'vue'

onBeforeMount(() => {
    console.log('before mounted');
});

onMounted(() => {
    console.log('mounted');
});
</script>