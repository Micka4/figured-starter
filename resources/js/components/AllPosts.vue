<template>
  <div class="post-container">
    <div v-for="(post, i) in posts" :key=i>
      <div class="card post">
        <h2>{{ post.title }}</h2>
        <p>{{ post.body }}.</p>
        <div class="footer">
          <i>Published at {{ post.created_at }} by {{ post.author_name }}</i>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
  .post-container {
    display:flex;
    flex-direction: column;
    flex:1;
  }
  .post {
    margin: 20px 100px;
  }
  .footer {
    text-align: right;
  }
</style>
<script>
import { mapState } from 'vuex';
export default {
  name: 'all-posts',
  computed: mapState(['posts']),
  beforeMount() {
    this.$store.dispatch('getAllPosts');
  },
}
</script>