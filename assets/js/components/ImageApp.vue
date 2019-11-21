<template>
    <div style="position:relative;">
        <div class="row no-gutters" style="box-shadow: 0 3px 7px 1px rgba(0,0,0,0.06);">
            <div class="col py-5">
                <h1 class="text-center">Ponka-fy Me</h1>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col px-5" style="background-color: #659dbd; min-height: 40rem;">
                <h2 class="text-center mb-5 pt-5 text-white">First: Upload Photo</h2>
                <image-uploader
                        v-on:new-image="onNewImageUploaded"
                ></image-uploader>
            </div>
            <div class="col px-5" style="background-color: #7FB7D7;">
                <h2 class="text-center mb-5 pt-5 text-white">Second: Download Improved Photo</h2>
                <image-list
                        :images="images"
                        :info="info"
                        v-on:delete-image="onImageDelete"
                ></image-list>
            </div>
        </div>
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
        }
        // created() {
        //     this.timer = setInterval(this.fetchImagesData, 2 * 1000);
        // },
        // beforeDestroy() {
        //     clearInterval(this.timer);
        // }
    };
</script>

<style scoped lang="scss">
    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        min-height: 60px;
        background-color: #f5f5f5;
    }
</style>
