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
  import axios from 'axios';
  import ImageItem from './ImageItem';

  export default {
    components: {
      ImageItem,
    },
    data () {
      return {
        images: [
          {id: 1}
        ],
        info: null
      }
    },
    mounted() {
      axios
          .get('/api/images')
          .then(response => (this.images = response.data.items))
    }
  }
</script>

<style>

</style>
