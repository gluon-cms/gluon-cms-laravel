<template>
    <div>
        <strong>{{ propertyName }}</strong>
        {{ value }}

        <template v-for="(transValue, lang) in value">
            <label>{{ lang }} <span v-if="initialValue[lang] != value[lang]">*</span></label>
            <textarea v-model="value[lang]" :name="inputName(lang)">
            </textarea>

            
        </template>


        
    </div>
</template>

<script>
    export default {
        name: "gluon-parameter-text",

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
                    this.value = Object.assign({}, this.initialValue)
                }
            }
        },

        methods: {
            inputName(key){
                return `${this.inputNamePrefix}[text.${this.propertyName}][${key}]`
            }
        },

        mounted() {
            
        }
    }
</script>
