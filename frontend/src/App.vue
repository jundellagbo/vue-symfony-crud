<template>
  <v-app>
    <v-layout justify-center>
      <v-flex md4>
        <v-card style="margin-top: 20px;">
          <v-card-text>
            <img :src="require('./assets/vue_symfony.png')" style="margin: 0 auto; display: block; width: 300px;" />
          </v-card-text>
          <v-card-title>
            <h3>Name List's</h3>
            {{ form.exists }}
            <v-spacer />
            <v-btn color="primary" @click="form = { dialog: true, inputs: { id: 0, fullname: '' } }">
              New Name
            </v-btn>
          </v-card-title>
          <v-card-text>
            <names-lists 
            :items="items" 
            @edit="edit"
            @remove="remove"
            :loading="loadingItems"
            />
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
    <name-form 
    :form="form"
    @close="form.dialog = false"
    @update="updateData"
    @insert="insertData"
    @alert="openAlert"
    />
    <app-alert 
    :alert="alert"
    @close="() => alert.open = false"
    />
  </v-app>
</template>

<script>
import {api} from "./api"
import NamesLists from './App.Lists.vue'
import AppAlert from './App.Alert.vue'
import NameForm from './App.Form.vue'

export default {
  name: 'App',
  components: {
    NamesLists,
    AppAlert,
    NameForm
  },
  data () {
    return {
      //
      alert: {
        open: false,
        message: 'Hello World',
        key: null,
        type: 'primary'
      },
      form: {
        inputs: {
          id: 0,
          fullname: ''
        },
        dialog: false
      },
      items: [],
      loadingItems: false
    }
  },
  mounted() {
    this.fetchNames();
  },
  methods: {
    fetchNames() {
      const e = this;
      e.loadingItems = true;
      api.get("/names")
      .then(( response ) => {
        e.items = response.data.items
      })
      .catch(( error ) => {
        e.openAlert({ message: error, type: 'error' })
      }).
      then(() => e.loadingItems = false)
    },
    edit(params) {
      this.form = {
        dialog: true,
        inputs: {...params}
      }
    },
    remove(params) {
      const e = this;
      api.get("/names/remove/" + params.id)
      .then(() => {
        e.items.splice( params.index, 1 )
        e.openAlert({ message: 'Successfully removed', type: 'success' })
      })
      .catch(( error ) => {
        e.openAlert({ message: error, type: 'error' })
      })
    },
    openAlert( param ) {
      this.alert = {
        key: Date.now(),
        open: true,
        message: param.message,
        type: param.type
      }
    },
    updateData( param ) {
      this.$set(this.items, param.index, param)
    },
    insertData( param ) {
      this.items.push( param )
    }
  }
}
</script>
