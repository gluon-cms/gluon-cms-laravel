<template>
    <div class="helloComponent">
        <p>A message from vue : {{ messageFromVue }}</p>
        <p>A message from blade : {{ messageFromBlade }}</p>
        <p>Some data from blade : {{ dataFromBlade }}</p>
    </div>
</template>

<script>
    export default {
        props: [
            'messageFromBlade',
            'dataFromBlade'
        ],

        data(){
            return {
                'messageFromVue': 'I ❤ VUE'
            }
        },

        mounted() {
            console.log('Hello component')
            console.log(this.messageFromBlade)
            console.log(this.dataFromBlade)
        }
    }
</script>

<style type="text/css">
    .helloComponent {
        border: 1px solid black;
        padding: 1em;
    }
</style>