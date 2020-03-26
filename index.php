<?php
    // errors
    $errors = [];

    // post 
    if (isset($_POST['success'])) {
        $function = getFunction($_POST['function']);
        echo json_encode($function);
    }

    function getFunction($code) {

        $functions = [
            'get_factors'    => "
                acl('get_factors');
            ",
            'collect_factor' => "
                acl('collect_factor', [
                    'factorgroup' => '',
                    'factorname'  => '',
                    'factorvalue' => ''
                ]);
            ",
            'get_records' => "
                acl('get_records');
            ",
            'collect_record' => "
                acl('collect_record', [
                    'code' => ''
                ]);
            ",
            'get_variable' => "
                acl('get_variable', [
                    'level' => 'session',
                    'name'  => 'greeting'
                ]);
            ",
            'set_variable' => "
                acl('set_variable', [
                    'level' => 'session',
                    'name'  => 'greeting',
                    'value' => 'Hello World'
                ]);
            ",
            'whoami' => "
                acl('whoami');
            ",
            'get_session' => "
                acl('get_session');
            ",
        ];

        if ($functions[$code]) {
            return $functions[$code];
        } else {
            return 'not found';
        }

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
                        Function Found!
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
            output: '',
            alert_error: null,
            alert_success: null,
            items: [
                {name: "Get Factors", value: "get_factors"},
                {name: "Collect Factor", value: "collect_factor"},
                {name: "Get Records", value: "get_record"},
                {name: "Collect Record", value: "collect_record"},
                {name: "Get User Information", value: "whoami"}
            ],
            select: {name: "Get Factors", value: "get_factors"},
            radios_create: true,
        }),
        methods: {
            submit () {
                var me = this;
                var params = new URLSearchParams();
                params.append('function', me.select.value);
                params.append('success', me.radios_create);
                axios.post('http://our.local.test/function-abstractor/index.php', params)
                    .then(response => {
                    me.output = response.data;
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
