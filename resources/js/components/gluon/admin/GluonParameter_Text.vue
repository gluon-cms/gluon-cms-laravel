<template>
    <div class="multiText">

        <ul class="multiText__choices">
            <template v-for="(transValue, lang) in value">
            <li @click="currentLang=lang" class="multiText__choice" :class="{selected: currentLang==lang, updated: (initialValue[lang] != value[lang])}">{{ lang }}</li>
            </template>
        </ul>

        <div class="multiText__widgets">
            <template v-for="(transValue, lang) in value" >
                <textarea v-model="value[lang]" :name="inputName(lang)" class="multiText__widget" :class="{selected: currentLang==lang}">
                </textarea>
            </template>

        </div>

        <!--template v-if="constraints && constraints.style == 'rich'">(RICH)</template-->
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
                'value': null,
                'currentLang': 'fr'
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
                return `${this.inputNamePrefix}[${key}]`
            }
        },

        mounted() {
            
        }
    }
</script>

<style type="text/css">

    .multiText {
        position: relative;
    }

    .multiText__choices {
        text-align: right;
        position: absolute;
        padding: 0.5em;
        background: white;

        top: 3px;
        right: 3px;



    }

    .multiText__choice {
        display: inline-block;
        text-transform: uppercase;

        margin-right: 0.3em;
        margin-bottom: 0.1em;

        opacity: .5;
        cursor: pointer;
    }

    .multiText__choice.selected {
        font-weight: bold;
        border-bottom: 0px solid var(--line-color);
        opacity: 1;
    }

    .multiText__choice.updated:after {
        content: "*";
        color: red;
        font-size: 0.9em;
    }


    .multiText__widget {
        display: block;
        width: calc(100% - 1em);
        height: 10em;
        padding: 0.5em;
        font-size: 1em;

        border: 1px solid var(--line-color);
        display: none;
    } 

    .multiText__widget:focus{
        outline: 2px solid var(--line-color);

    }

    .multiText__widget.selected {
        display: block;
    }
 
</style>
