<template>
    <div class="row">
        <div class="col-3">
            <div class="card sticky-top" style="top: 30px">
                <div class="list-group list-group-flush">
                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('branch-index')">
                        {{ "Branch" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('department-index')">
                        {{ "Department" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('designation-index')">
                        {{ "Designation" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('leave-index')">
                        {{ "Leave Type" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('document-index')">
                        {{ "Document Type" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('allowance-index')">
                        {{ "Allowance Type" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('termination-index')">
                        {{ "Termination Type" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('transfer-index')">
                        {{ "Transfer Type" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('award-index')">
                        {{ "Award Type" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('traning-index')">
                        {{ "Training Type" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('job-category-index')">
                        {{ "Job Category" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>

                    <button class="list-group-item list-group-item-action border-0" @click="setSelectedComponent('job-stage-index')">
                        {{ "Job Stage" }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-9">
            <component :is="selectedComponent"></component>
        </div>
    </div>
</template>

<script>
// import HrSystemSideBar from "../component/hr_system_setup/HrSystemSideBar.vue";

import BranchIndex from "../component/hr_system_setup/branch/index.vue";
import DepartmentIndex from "../component/hr_system_setup/department/index.vue";
import DesignationIndex from "../component/hr_system_setup/designation/index.vue";
import LeaveIndex from "../component/hr_system_setup/leave/index.vue";
import DocumentIndex from "../component/hr_system_setup/document/index.vue";
import AllowanceIndex from "../component/hr_system_setup/allowance/index.vue";
import TerminationIndex from "../component/hr_system_setup/termination/index.vue";
import TransferIndex from "../component/hr_system_setup/transfer/index.vue";
import AwardIndex from "../component/hr_system_setup/award/index.vue";
import TraningIndex from "../component/hr_system_setup/traning/index.vue";
import JobCategoryIndex from "../component/hr_system_setup/job-category/index.vue";
import JobStageIndex from "../component/hr_system_setup/job-stage/index.vue";

export default {
    components: {
        BranchIndex,
        DepartmentIndex,
        DesignationIndex,
        LeaveIndex,
        DocumentIndex,
        AllowanceIndex,
        TerminationIndex,
        TransferIndex,
        AwardIndex,
        TraningIndex,
        JobCategoryIndex,
        JobStageIndex,
    },
    data() {
        return {
            selectedComponent: "branch-index",
        };
    },
    methods: {
        setSelectedComponent(cmp) {
            this.selectedComponent = cmp;
        },
    },
};
</script>
