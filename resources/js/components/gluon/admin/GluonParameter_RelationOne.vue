<template>
    <div class="relationOneWidget">
        {{ initialValue }}
    </div>
</template>

<script>
    export default {
        name: "gluon-parameter-relation-one",

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
    .relationOneWidget {
        
    }

</style>