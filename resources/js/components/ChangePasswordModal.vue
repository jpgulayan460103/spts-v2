<template>
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submitForm()" id="change-password-form">
                    <form-item label="Old Password" :errors="formErrors.old_password">
                        <input type="password" v-model="formData.old_password" class="form-control" :class="formErrors.old_password ? 'is-invalid' : ''">
                    </form-item>
                    <form-item label="New Password" :errors="formErrors.new_password">
                        <input type="password" v-model="formData.new_password" class="form-control" :class="formErrors.new_password ? 'is-invalid' : ''">
                    </form-item>
                    <form-item label="Confirm New Password" :errors="formErrors.new_password_confirmation">
                        <input type="password" v-model="formData.new_password_confirmation" class="form-control" :class="formErrors.new_password_confirmation ? 'is-invalid' : ''">
                    </form-item>
                    <!-- <button type="button" style="display:none">Button</button> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" ref="closeModal">Close</button>
                <button type="submit" class="btn btn-primary" form="change-password-form">Change Password</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import FormItem from './FormItem.vue';
    export default {
        components: {
            FormItem
        },
        data(){
            return {
                formErrors: {},
                formData: {},
            }
        },
        methods: {
            submitForm(){
                axios.post(route('change-password'), this.formData)
                .then(res => {
                    alert('Your password has been changed.');
                    this.formErrors = {};
                    this.formData = {};
                    this.$refs.closeModal.click();
                })
                .catch(err => {
                    this.formErrors = err.response.data.errors;
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
