<template>
    <v-snackbar
      v-model="alert.open"
      top="top"
      :key="alert.key"
      :color="alert.type"
    >
      {{ alert.message }}
      <v-btn
        flat
        @click="closeAlert"
      >
        Close
      </v-btn>
    </v-snackbar>
</template>

<script>
export default {
    props: {
        alert: Object
    },
    methods: {
        closeAlert() {
            this.$emit('close')
        }
    },
}
</script>