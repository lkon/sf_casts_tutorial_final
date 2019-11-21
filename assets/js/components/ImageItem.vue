<template>
    <li v-bind:class="{ deleting: isDeleting }" class="text-white pt-3">
        <div class="d-flex flex-row">
            <div>
                <a :href="url" target="_blank" rel="nofollow">
                    <img
                            :src="url"
                            :alt="originalFilename"
                    />
                </a>
            </div>
            <div class="pl-2">
                <span v-if="this.ponkaAddedAt">
                    Ponka visited your photo {{ ponkaAddedAgo }}
                </span>
                <span v-else>
                    Ponka is napping. Check back soon.
                </span>
            </div>
            <div class="pl-2">
                <button title="clear image" @click="onDeleteClick" class="btn btn-default font-weight-bold text-white">X
                </button>
            </div>
        </div>
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

<style scoped lang="scss">
    img {
        width: 100px;
        border-radius: 5px;
    }

    .deleting {
        opacity: .3;
    }

    button {
        cursor: pointer;
    }

</style>
