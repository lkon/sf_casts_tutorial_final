<template>
    <div>
        <vue-dropzone
                ref="myVueDropzone"
                id="dropzone"
                v-on:vdropzone-success="onDropzoneSuccess"
                :options="dropzoneOptions"
        ></vue-dropzone>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        name: 'app',
        components: {
            vueDropzone: vue2Dropzone
        },
        data: function () {
            return {
                dropzoneOptions: {
                    url: '/api/images',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5
                }
            }
        },
        methods:{
            onDropzoneSuccess(file, resp){
                this.$emit('new-image', resp);
                this.$refs.myVueDropzone.removeFile(file);
            }
        }
    }
</script>
