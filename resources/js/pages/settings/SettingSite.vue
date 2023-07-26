<template>
    <PageHeader title="Setting" breadcrumb="" />
    <div class="bd-example">
        <div class="row">
            <div class="col-4">
                <div id="list-example" class="list-group">
                    <a class="list-group-item list-group-item-action" href="#list-item-1">Company Setting</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-2">System Setting</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-3">Mail Setting</a>
                    <a class="list-group-item list-group-item-action" href="#list-item-4">Email notification</a>
                </div>
            </div>
            <div class="col-7">
                <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="setting-right" tabindex="0">
                    <SettingCompany />

                    <SettingSystem />

                    <SettingMail />

                    <SettingMailNotification />
                    
                    <span style="margin-bottom: 100px"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.setting-right {
    position: relative;
    height: calc(100vh - (64px + 20px));
    overflow: auto;
}
</style>

<script setup>
import PageHeader from "../../layouts/PageHeader.vue";
import SettingCompany from "../../components/SettingSite/SettingCompany.vue";
import SettingSystem from "../../components/SettingSite/SettingSystem.vue";
import SettingMail from "../../components/SettingSite/SettingMail.vue";
import SettingMailNotification from "../../components/SettingSite/SettingMailNotification.vue";
</script>