import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  state: {
    posts: [],
    myPosts: []
  },

  actions: {
    async getAllPosts({ commit }) {
      return commit('setPosts', await axios.get('/post/'))
    },
    async getMyPosts({ commit }) {
        return commit('setMyPosts', await axios.get('/post/'))
    },
    async deletePost({ commit} , post) {
        return commit('removePost', await axios.delete(`/post/${post._id}`))
    },
    async savePost({ commit }, post) {
        return commit('replacePost', await axios.put(`/post/${post._id}`, post))
    }
  },

  mutations: {
    setPosts(state, response) {
      state.posts = response.data;
    },
    setMyPosts(state, response) {
        state.myPosts = response.data;
    },
    removePost(state, response) {
        state.myPosts = state.myPosts.filter(post => {
            return post._id !== response.data;
        });
    },
    replacePost(state, response) {
        const updatedPost = state.myPosts.find(post => post._id === response.data._id);
        Object.assign(updatedPost, response.data);
    }
  },
  strict: debug
});