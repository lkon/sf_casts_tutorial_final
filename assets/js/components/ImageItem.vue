<template>
    <li :class="{deleting: isDeleting}">
        <a :href="url" target="_blank" rel="nofollow">
            <img
                    :src="url"
                    :alt="originalFilename"
            />
        </a>
        <span v-if="this.ponkaAddedAt">
            Ponka visited your photo {{ ponkaAddedAgo }}
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
                isDeleting: false,
                ponkaAddedAgo: null
            };
        },
        methods: {
            onDeleteClick() {
                this.$emit('delete-image');
                this.isDeleting = true;
            },
            updatePonkaAddedAtAgo() {
                this.ponkaAddedAgo = moment(this.ponkaAddedAt).fromNow();
            }
        },
        watch: {
            ponkaAddedAt() {
                this.updatePonkaAddedAtAgo();
            }
        },
        created() {
            this.updatePonkaAddedAtAgo();
            this.timer = setInterval(this.updatePonkaAddedAtAgo, 60 * 1000);
        },
        beforeDestroy() {
            clearInterval(this.timer);
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
