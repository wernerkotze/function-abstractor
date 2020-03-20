<?php
    // errors
    $errors = [];

    // post
    if(isset($_POST["submit"])) {

    }

    // get
    if (isset($_GET['action'])) {

    }
?>
<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
  <div id="app">
    <v-app>
      <v-content>
        <v-container>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                     <v-alert
                        v-model="alert_error"
                        dismissible
                        type="error"
                        >
                        An error has occured, please check log.
                    </v-alert>
                    <v-alert
                        v-model="alert_success"
                        dismissible
                        type="success"
                        >
                        Folder Path Successfully Created!
                    </v-alert>
                    <v-card class="elevation-12">
                    <v-toolbar color="light-blue">
                        <v-toolbar-title color="white">Function Abstractor</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                    <v-form v-model="valid">
                        <v-combobox
                        prepend-icon="adjust"
                        v-model="select"
                        :items="items"
                        label="ACL Function"
                        item-text="name"
                        item-value="value"
                        ></v-combobox>
                    </v-form>
                    <v-textarea
                        prepend-icon="code"
                        v-model="output"
                        label="Result"
                        disabled
                    ></v-textarea>
                    <div>
                        <code>&lt;code&gt;</code>
                    </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                        color="white"
                        :disabled="!valid"
                        @click="submit"
                        >Submit</v-btn>
                    </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
      </v-content>
    </v-app>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script>
    const API = "../../apiva"
    new Vue({
      el: '#app',
      vuetify: new Vuetify(),
        data: () => ({
            valid: false,
            path: '',
            pathRules: [
                v => !!v || 'Folder Path is required',
                v => v.length <= 30 || 'Path must be less than 30 characters'
            ],
            output: '',
            alert_error: null,
            alert_success: null,
            items: [
                {name: "Property Group", value: "propertygroup"},
                {name: "Product", value: "product"},
                {name: "Account", value: "account"},
                {name: "Process", value: "process_folder"},
                {name: "Department", value: "user"}
            ],
            select: {name: "Property Group", value: "propertygroup"},
            radios_create: 'true',
            radios_delimeter: 'false',
        }),
        methods: {
            submit () {
                var me = this;
                var params = new URLSearchParams();
                if (me.select.value === 'user') {
                    me.select.value = null;
                    params.append('classtype', 'object');
                }
                params.append('path', me.path);
                params.append('itemtype', me.select.value);
                params.append('create', me.radios_create);
                params.append('delimeter', me.radios_delimeter);
                axios.post(API + '/admin/folder/save', params)
                    .then(response => {
                    me.output = me.path;
                    me.alert_success = true;
                    console.log(response);
                    })
                    .catch(e => {
                    me.alert_error = true,
                    console.log(e);
                })
            },
        }
    })
  </script>
</body>
</html>
