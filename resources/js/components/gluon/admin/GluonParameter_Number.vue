<template>
    <div class="numberWidget" :class="{updated: (initialValue != value)}">
        <input type="text" :name="inputName" v-model="value" />
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

<style type="text/css">
    .numberWidget {
        position: relative;
    }

    .numberWidget input {
        display: block;
        width: calc(100% - 1em);
        height: 1em;
        padding: 0.5em;
        font-size: 1em;

        border: 1px solid var(--line-color);

    } 

    .numberWidget input:focus {
        outline: 2px solid var(--line-color);
    }

    .numberWidget.updated::after {
        content: "*";
        position: absolute;
        color: red;
        top: 0em;
        right: 0em;

        display: block;
        padding: .5em;

    }
</style>