<template>
  <div>
      <transition-group name="list" tag="ul">
      <image-item
              v-for="image in images"
              :key="image.id"
              :url="image.url"
              :original-filename="image.originalFilename"
              :ponka-added-at="image.ponkaAddedAt"
              v-on:delete-image="onDeleteImage(image)"
      ></image-item>
      </transition-group>
  </div>
</template>

<script>
  import ImageItem from './ImageItem';

  export default {
    name: 'ImageList',
    props: ['images'],
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

<style scoped lang="scss">
    .list-enter-active, .list-leave-active {
      transition: all 1s;
    }
    .list-enter, .list-leave-to {
      opacity: 0;
      transform: translateY(30px);
    }
    ul {
        list-style: none
    }
</style>
