<template>
    <div>
        <strong>{{ propertyName }}</strong>

        <template v-for="(transValue, lang) in value">
            <label>{{ lang }} <span v-if="initialValue[lang] != value[lang]">*</span></label>
            <textarea v-model="value[lang]" :name="inputName(lang)">
            </textarea>

            

        </template>
        <template v-if="constraints && constraints.style == 'rich'">(RICH)</template>
    </div>
</template>

<script>
    export default {
        name: "gluon-parameter-text",

        props: [
            'propertyName','initialValue','inputNamePrefix', 'constraints'
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
                let prefix = this.inputNamePrefix ? this.inputNamePrefix : 'entity'
                return `${prefix}[text.${this.propertyName}][${key}]`
            }
        },

        mounted() {
            
        }
    }
</script>
