<template>
    <v-dialog
      v-model="form.dialog"
      width="500"
      :persistent="true"
    >
        <v-card>
            <v-card-title>
                <h3>{{ inputs.id != 0 ? 'Edit Name' : 'New Name' }}</h3>
            </v-card-title>
            <v-card-text>
                <v-form ref="nameForm">
                    <v-text-field
                        v-model="inputs.fullname"
                        :rules="rule"
                        label="Enter Fullname"
                        solo
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" :loading="loadingSubmit" @click="storeData">
                    {{ inputs.id != 0 ? 'Save Changes' : 'Add To Lists' }}
                </v-btn>
                <v-btn flat color="primary" @click="cancelForm">
                    Cancel
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { api } from "./api"
export default {
    data() { return {
        inputs: {},
        loadingSubmit: false
    } },
    props: {
        form: Object
    },
    computed: {
        rule() {
            return [
                v => !!v || 'Fullname is required'
            ]
        }
    },
    watch: {
        form(val) {
            this.inputs = val.inputs;
            this.$refs.nameForm.resetValidation();
        }
    },
    methods: {
        cancelForm() {
            this.$refs.nameForm.reset();
            this.$refs.nameForm.resetValidation();
            this.$emit('close')
        },
        storeToApi() {
            const e = this;
            const inputs = {...e.inputs}
            e.loadingSubmit = true;
            api.post("/names/save", inputs)
            .then(( response ) => {
                let result = {...response.data.response}
                if( inputs.id != 0 ) {
                    result.index = inputs.index
                    this.$emit('update', result)
                    this.$emit('alert', { message: 'Saved changes', type: 'success' })
                } else {
                    this.$emit('insert', result)
                    this.$emit('alert', { message: 'New name has been added', type: 'success' })
                }
                this.cancelForm();
            })
            .catch(( error ) => {
                this.$emit('alert', { message: error, type: 'error' })
            })
            .then(() => e.loadingSubmit = false)
        },
        storeData() {
            if( !this.$refs.nameForm.validate() ) {
                this.$emit('alert', { message: 'Please check the error fields', type: 'error' })
            } else {
                this.storeToApi();
            }
        }
    },
}
</script>