<template>
    <div class="relationManyWidget " :class="{readOnly}" @click="readOnly=false">

        
        <transition-group tag='ul' name="entity-list">
            <li v-for="(related, index) in orderedList" class="entity" :class="{deleted:related.deleted}" :key="related.entity.id">
                <span>{{ related.entity.label.fr }}</span>

                <span class="rankChange" @click.prevent="rankChange(-1, related)">&uarr;</span> 
                <span class="rankChange" @click.prevent="rankChange(1, related)">&darr;</span>  

                <span class="remove" @click.prevent="remove(related, index)">&times;</span>
            </li>
        </transition-group>
        
    </div>
</template>

<script>
    export default {
        name: "gluon-parameter-relation-many",

        props: [
            'propertyName','initialValue','inputNamePrefix'
        ],

        data() {
            return {
                'list': null, 
                'readOnly': true
            }
        },

        watch:{
            initialValue: {
                immediate: true,
                handler(){
                    this.list = this.initialValue
                }
            }
        },

        computed: {
            inputName(){
                return this.inputNamePrefix
            },

            orderedList(){
                return this.list.sort((item1, item2)=>{
                    return item1['rank'] - item2['rank'];
                })
            }


        },

        mounted() {
            
        },

        methods: {
            rankChange(value, entity){
                entity.rank += value;
            },

            remove(entity){
                entity.deleted = !entity.deleted;
            },            
        }
    }
</script>

<style type="text/css">
    

    .relationManyWidget {
        
    }

    
    .relationManyWidget .entity {
        margin-bottom: .5em;
    }

    .relationManyWidget .entity.deleted {
        opacity: 0.2;
    }

    .relationManyWidget .entity:before {
        content:"• ";
    }

    .relationManyWidget .rankChange {
        transition: all .2s;
        background: var(--dark-color);
        padding: .2em;
        min-width: 1em;
        height: 0.9em;
        color: var(--light-color);
        

        display: inline-block;
        text-align: center;
        cursor: pointer;
        overflow: hidden;
    }

    .relationManyWidget .remove {
        transition: all .2s;
        background: red;
        padding: .2em;
        min-width: 1em;
        height: 0.9em;
        color: var(--light-color);
        
        cursor: pointer;
        display: inline-block;
        text-align: center;
        overflow: hidden;
    }

    .relationManyWidget.readOnly {
        cursor: pointer;
    }

    .relationManyWidget.readOnly .rankChange, .relationManyWidget.readOnly .remove {
        width: 0;
        min-width: 0em;
        padding-left: 0;
        padding-right: 0;
        
    }

    .entity {
      transition: all .3s;
    }
    .entity-list-enter, .entity-list-leave-to
    /* .entity-list-leave-active below version 2.1.8 */ {
      opacity: 0;
      transform: translateY(30px);
    }
    .entity-list-leave-active {
      position: absolute;
    }


</style>