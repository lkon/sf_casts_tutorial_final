<template>
  <div>
    <ul>
      <image-item
              v-for="image in images"
              :key="image.id"
              :url="image.url"
              :original-filename="image.originalFilename"
      ></image-item>
    </ul>
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
    }
  }
</script>

<style>

</style>
