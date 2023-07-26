<template>
    <div class="card mt-4">
        <div id="recaptcha-print-setting" class="card">
            <div class="col-md-12">
                <form method="POST" action="https://hrpayroll.codecloudtech.com/recaptcha-settings" accept-charset="UTF-8">
                    <div class="card-header">
                        <a href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/" target="_blank" class="text-blue">
                            <h5 class="">ReCaptcha settings</h5>
                            <small class="text-secondary font-weight-bold">(How to Get Google reCaptcha Site and Secret key)</small>
                        </a>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="_token" value="BA2n7dQQ1AUMq6wbUzx2UjbaGaFonsYCUgMRKHMg" />
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                <label for="google_recaptcha_key" class="form-label">Google Recaptcha Key</label>
                                <input
                                    class="form-control"
                                    placeholder="Enter Google Recaptcha Key"
                                    name="google_recaptcha_key"
                                    type="text"
                                    value=""
                                    id="google_recaptcha_key"
                                />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                <label for="google_recaptcha_secret" class="form-label">Google Recaptcha Secret</label>
                                <input
                                    class="form-control"
                                    placeholder="Enter Google Recaptcha Secret"
                                    name="google_recaptcha_secret"
                                    type="text"
                                    value=""
                                    id="google_recaptcha_secret"
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>