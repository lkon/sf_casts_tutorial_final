<template>
    <li :class="{deleting: isDeleting}">
        <a :href="url" target="_blank" rel="nofollow">
            <img
                :src="url"
                :alt="originalFilename"
            />
        </a>
        <button @click="onDeleteClick">x</button>
    </li>
</template>

<script>
    export default {
        name: 'ImageItem',
        props: ['url', 'originalFilename'],
        data() {
            return {
                isDeleting: false
            };
        },
        methods: {
            onDeleteClick() {
                this.$emit('delete-image');
                this.isDeleting = true;
            }
        }
    };
</script>

<style scoped>
    img {
        width: 100px;
    }
    .deleting {
        opacity: .3;
    }
</style>
