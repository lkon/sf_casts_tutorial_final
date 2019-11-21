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
        mounted() {
            axios
                .get('/api/images')
                .then(response => (this.images = response.data.items));
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
            }
        }
    };
</script>

<style scoped>

</style>
