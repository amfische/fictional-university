import axios from "axios";

class MyNotes {
  constructor() {
    this.deleteBtns = document.querySelectorAll('.delete-note');
    this.editBtns = document.querySelectorAll('.edit-note');
    this.saveBtns = document.querySelectorAll('.update-note');
    this.newNote = {
      title: document.querySelector('.new-note-title'),
      content: document.querySelector('.new-note-body'),
      createBtn: document.querySelector('.submit-note')
    }
    this.notesList = document.getElementById('my-notes');
    this.noteLimitMsg = document.querySelector('.note-limit-message');
  }

  init() {
    // this.deleteBtns.forEach(btn => btn.addEventListener('click', this.deleteNote.bind(this)));
    // this.editBtns.forEach(btn => btn.addEventListener('click', this.toggleNoteEditor.bind(this)));
    // this.saveBtns.forEach(btn => btn.addEventListener('click', this.updateNote.bind(this)));
    if (this.notesList === null) {
      return;
    }
    this.notesList.addEventListener('click', this.clickHandler.bind(this));
    this.newNote.createBtn.addEventListener('click', this.createNote.bind(this));
  }

  clickHandler(e){
    if (e.target.classList.contains("delete-note") || e.target.classList.contains("fa-trash-o")) {
      this.deleteNote(e);
    }
    if (e.target.classList.contains("edit-note") || e.target.classList.contains("fa-pencil") || e.target.classList.contains("fa-times")) {
      this.toggleNoteEditor(e);
    }
    if (e.target.classList.contains("update-note") || e.target.classList.contains("fa-arrow-right")) {
      this.updateNote(e);
    }
  }

  deleteNote(e) {
    var noteNode = e.target.closest('li');
    var config = {
      'headers': {
        'X-WP-Nonce': universityData.nonce
      }
    }
    axios.delete(`${universityData.root_url}/wp-json/wp/v2/note/${noteNode.dataset.id}`, config)
      .then(res => {
        noteNode.classList.add('fade-out');
        if (res.data.user_note_count < 5) {
          this.noteLimitMsg.classList.remove('active');
        }
        console.log('congrats', res)
      })
      .catch(err => {
        console.log('failed', err.response)
      })
  }

  toggleNoteEditor(e) {
    var noteNode = e.target.closest('li');
    var input = noteNode.querySelector('.note-title-field');
    var textarea = noteNode.querySelector('.note-body-field');
    var editBtn = noteNode.querySelector('.edit-note');
    var saveBtn = noteNode.querySelector('.update-note');

    if (noteNode.dataset.state === 'editable'){
      input.setAttribute('readonly', 'readonly');
      input.classList.remove('note-active-field');
      textarea.setAttribute('readonly', 'readonly');
      textarea.classList.remove('note-active-field');
      saveBtn.classList.remove('update-note--visible');
      editBtn.innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit';
      noteNode.dataset.state = 'cancel';
    } else {
      input.removeAttribute('readonly');
      input.classList.add('note-active-field');
      textarea.removeAttribute('readonly');
      textarea.classList.add('note-active-field');
      saveBtn.classList.add('update-note--visible');
      editBtn.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i> Cancel';
      noteNode.dataset.state = 'editable';
    }
  }

  updateNote(e) {
    var noteNode = e.target.closest('li');
    var config = {
      headers: {
        'X-WP-Nonce': universityData.nonce
      }
    }
    var data = {
      title: noteNode.querySelector('.note-title-field').value,
      content: noteNode.querySelector('.note-body-field').value
    }
    axios.put(`${universityData.root_url}/wp-json/wp/v2/note/${noteNode.dataset.id}`, data, config)
      .then(res => {
        this.toggleNoteEditor(e);
        console.log('congrats', res)
      })
      .catch(err => {
        console.log('failed', err.response)
      })
  }

  createNote(e) {
    var config = {
      headers: {
        'X-WP-Nonce': universityData.nonce
      }
    }
    var data = {
      title: this.newNote.title.value,
      content: this.newNote.content.value,
      status: 'publish'
    }
    axios.post(`${universityData.root_url}/wp-json/wp/v2/note`, data, config)
      .then(res => {
        this.newNote.title.value = '';
        this.newNote.content.value = '';
        this.notesList.insertAdjacentHTML(
          "afterbegin",
          ` <li data-id="${res.data.id}" class="fade-in-calc">
            <input readonly class="note-title-field" value="${res.data.title.raw}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${res.data.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          </li>`
        )
        var newNoteNode = document.querySelector(`li[data-id="${res.data.id}"]`)
        setTimeout(function () {
          newNoteNode.classList.remove("fade-in-calc");
        }, 50)
        console.log('congrats', res)
      })
      .catch(err => {
        if (err.response.data.data.msg === 'You have reached your note limit.') {
          this.noteLimitMsg.classList.add('active')
        }
        console.log('failed', err.response, err.response.data)
      })
  }
}

export default MyNotes;
