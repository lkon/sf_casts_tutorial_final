<template>
  <div>
      <transition-group name="list" tag="ul">
      <image-item
              v-for="image in images"
              :key="image.id"
              :url="image.url"
              :original-filename="image.originalFilename"
              v-on:delete-image="onDeleteImage(image)"
      ></image-item>
      </transition-group>
    <div>
      {{ info }}
    </div>
  </div>
</template>

<script>
  import ImageItem from './ImageItem';

  export default {
    name: 'ImageList',
    props: ['images', 'info'],
    components: {
      ImageItem,
    },
    methods:{
      onDeleteImage(item){
        this.$emit('delete-image', item)
      }
    }
  }
</script>

<style>
  .list-enter-active, .list-leave-active {
    transition: all 1s;
  }
  .list-enter, .list-leave-to {
    opacity: 0;
    transform: translateY(30px);
  }
</style>
