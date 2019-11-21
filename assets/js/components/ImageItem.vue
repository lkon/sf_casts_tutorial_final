<template>
    <li>
        <a :href="url">
            <img
                :src="url"
                :alt="originalFilename"
            />
        </a>
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
