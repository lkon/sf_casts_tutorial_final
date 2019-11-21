<template>
    <li>
        <img
                :src="url"
                :alt="originalFilename"
        />
    </li>
</template>

<script>
    export default {
        name: 'ImageItem',
        props: ['url', 'originalFilename']
    };
</script>

<style scoped>
    img {
        width: 100px;
    }
</style>
