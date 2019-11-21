<template>
    <div class="">
        <image-uploader
                v-on:new-image="onNewImageUploaded"
        ></image-uploader>
        <image-list
                :images="images"
                :info="info"
                v-on:delete-image="onImageDelete"
        ></image-list>
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
        data() {
            return {
                images: [],
                info: null
            };
        },
        methods: {
            onNewImageUploaded(image) {
                this.images.unshift(image);
            },
            onImageDelete(image) {
                axios
                    .delete(image['@id'])
                    .then(() => {
                        this.$delete(this.images, this.images.indexOf(image));
                    });
            },
            fetchImagesData() {
                axios
                    .get('/api/images')
                    .then(response => (this.images = response.data.items));
            }
        },
        mounted() {
            this.fetchImagesData();
        },
        // created() {
        //     this.timer = setInterval(this.fetchImagesData, 2 * 1000);
        // },
        // beforeDestroy() {
        //     clearInterval(this.timer);
        // }
    };
</script>

<style scoped>

</style>
