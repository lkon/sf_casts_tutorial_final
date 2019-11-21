<template>
    <li :class="{deleting: isDeleting}">
        <a :href="url" target="_blank" rel="nofollow">
            <img
                :src="url"
                :alt="originalFilename"
            />
        </a>
        <span v-if="this.ponkaAddedAt">
            Ponka visited your photo {{ ponkaAddedAtAgo() }}
        </span>
        <span v-else>
            Ponka is napping. Check back soon.
        </span>
        <button @click="onDeleteClick">x</button>
    </li>
</template>

<script>
    import moment from 'moment';

    export default {
        name: 'ImageItem',
        props: ['url', 'originalFilename', 'ponkaAddedAt'],
        data() {
            return {
                isDeleting: false
            };
        },
        methods: {
            onDeleteClick() {
                this.$emit('delete-image');
                this.isDeleting = true;
            },
            ponkaAddedAtAgo(){
                return moment(this.ponkaAddedAt).fromNow();
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
