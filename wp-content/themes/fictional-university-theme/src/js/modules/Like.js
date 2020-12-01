import axios from "axios"

class Like {
  constructor() {
    this.likeBtn = document.querySelector('.like-box');
    this.likeCount = document.querySelector('.like-count');
  }

  init() {
    if (this.likeBtn === null) {
      return;
    }
    this.likeBtn.addEventListener('click', this.handleClick.bind(this));
  }

  handleClick(e) {
    // const likeBtn = e.target.closest('.like-box');
    if (this.likeBtn.dataset.exists === 'yes') {
      this.deleteLike()
    }
    else {
      this.createLike()
    }
  }

  createLike() {
    const data = {
      professorId: this.likeBtn.dataset.id,
    }
    const config = {
      'headers': {
        'X-WP-Nonce': universityData.nonce
      }
    }
    axios.post(`${universityData.root_url}/wp-json/university/v1/manage-like`, data, config)
    .then(res => {
      this.likeBtn.dataset.exists = 'yes';
      this.likeCount.innerText = parseInt(this.likeCount.innerText, 10) + 1;
      console.log(res, 'success create');
    })
    .catch(err => {
      alert(err.response.data.data.msg);
      console.log(err.response, 'failed');
    })
  }

  deleteLike() {
    const config = {
      data: {
        professorId: this.likeBtn.dataset.id
      },
      headers: {
        'X-WP-Nonce': universityData.nonce
      }
    }
    axios.delete(`${universityData.root_url}/wp-json/university/v1/manage-like`, config)
    .then(res => {
      this.likeBtn.dataset.exists = 'no';
      this.likeCount.innerText = parseInt(this.likeCount.innerText, 10) - 1;
      console.log(res, 'success delete');
    })
    .catch(err => {
      alert(err.response.data.data.msg);
      console.log(err.response, 'failed delete');
    })
  }
}

export default Like;
