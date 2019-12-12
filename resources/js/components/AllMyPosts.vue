<template>
  <div class="row">
    <div class="col-md-6" v-for="(post, i) in myPosts" :key=i>
      <div class="card mt-4">
        <img v-if="post.post_images && post.post_images.length" class="card-img-top" :src="post.post_images[0].post_image_path">
        <div class="card-body">
          <p class="card-text"><strong>{{ post.title }}</strong> <br>
            {{ truncateText(post.body) }}
          </p>
        </div>
        <button class="btn btn-success m-2" @click="editPost(post)">Edit Post</button>
        <button class="btn btn-danger m-2" @click="deletePost(post)">Delete Post</button>
      </div>
    </div>
    <el-dialog v-if="currentPost" :visible.sync="postDialogVisible" width="40%">
      <div v-if=status_msg :class="'alert-danger'" class="alert" role="alert">
        {{ status_msg }}
      </div>
      <form>
        <div class="form-group">
          <label for="exampleFormControlInput1">Title</label>
          <input v-model="currentPost.title" type="text" class="form-control" id="title" placeholder="Post Title" required>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Post Content</label>
          <textarea v-model="currentPost.body" class="form-control" id="post-content" rows="3" required></textarea>
        </div>
        <div class="">
          <el-upload
            action="https://jsonplaceholder.typicode.com/posts/"
            list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :on-change="updateImageList"
            :auto-upload="false">
            <i class="el-icon-plus"></i>
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
          </el-dialog>
        </div>
      </form>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="postDialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="saveCurrentPost()">Save</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  name: 'all-posts',
  data() {
    return {
      dialogImageUrl: '',
      dialogVisible: false,
      imageList: [],
      status_msg: '',
      status: '',
      postDialogVisible: false,
      currentPost: null,
    };
  },
  computed: mapState(['myPosts']),
  beforeMount() {
    this.$store.dispatch('getMyPosts');
  },
  methods: {
    truncateText(text) {
      if (text && text.length > 24) {
        return `${text.substr(0, 24)}...`;
      }
      return text;
    },
    deletePost(post) {
      this.$store.dispatch('deletePost', post);
    },
    updateImageList(file) {
      this.imageList.push(file.raw);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.imageList.push(file);
      this.dialogVisible = true;
    },
    editPost(post) {
      this.currentPost = Object.assign({}, post);
      this.postDialogVisible = true;
    },
    saveCurrentPost() {
      this.status = this.validateForm(this.currentPost);
      if (!this.status.isValid) {
        this.showNotification(this.status.message);
        return;
      }
      this.$store.dispatch('savePost', this.currentPost);
      this.currentPost = null;
    },
    validateForm(post) {
      const status =  { isValid: true, message: ''};
      if (!post.title || !post.body) {
        status.message = 'Post title and body cannot be empty';
        status.isValid = false;
      }
      return status;
    },
    showNotification(message) {
      this.status_msg = message;
      setTimeout(() => {
        this.status_msg = '';
      }, 3000);
    }
  },
}
</script>