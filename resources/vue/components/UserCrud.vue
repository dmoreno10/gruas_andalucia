<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md" v-html="title"></div>
            <button @click="changeTitle">test</button>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title: 'TEST',
        }
    },
    methods: {
        changeTitle() {
            this.title = 'TITULO';
        }
    },
    watch: {
        title() {
            console.log(this.title);
        }
    },
    mounted() {
        console.log(this.title);
    }
}
</script>
