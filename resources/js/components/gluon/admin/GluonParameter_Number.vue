<template>
    <div>
        <strong>{{ propertyName }}</strong>
        <input type="text" :name="inputName" v-model="value" />

        <span v-if="initialValue != value">updated!</span>
    </div>
</template>

<script>
    export default {
        name: "gluon-parameter-number",

        props: [
            'propertyName','initialValue','inputNamePrefix'
        ],

        data() {
            return {
                'value': null
            }
        },

        watch:{
            initialValue: {
                immediate: true,
                handler(){
                    this.value = this.initialValue
                }
            }
        },

        computed: {
            inputName(){
                return this.inputNamePrefix
            }
        },

        mounted() {
            
        }
    }
</script>
