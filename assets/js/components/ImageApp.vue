<template>
<div class="">
    <image-uploader></image-uploader>
    <image-list
            :images="images"
            :info="info"></image-list>
</div>
</template>


<script>
    import axios from 'axios';
    import ImageUploader from './ImageUploader';
    import ImageList from './ImageList';

    export default {
        name: 'ImageApp',
        components: {
            ImageUploader,
            ImageList
        },
        data () {
            return {
                images: [],
                info: null
            }
        },
        mounted() {
            axios
                .get('/api/images')
                .then(response => (this.images = response.data.items))
        }
    };
</script>

<style scoped>

</style>
