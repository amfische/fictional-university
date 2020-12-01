// noinspection DuplicatedCode
class Search {
  constructor() {
    this.body = document.querySelector('body');
    this.openButtons = document.querySelectorAll('.js-search-trigger');
    this.closeButton = document.querySelector('.search-overlay__close');
    this.searchOverlay = document.querySelector('.search-overlay');
    this.inputField = document.getElementById('search-term');
    this.resultsDiv = document.getElementById('search-overlay__results');
    this.searchTerm = '';
    this.timeoutId = undefined;
    this.isOverlayOpen = false;
    this.fetchingResults = false;
  }

  init() {
    this.openButtons.forEach(btn => btn.addEventListener('click', this.openOverlay.bind(this)));
    this.closeButton.addEventListener('click', this.closeOverlay.bind(this));
    document.addEventListener('keydown', this.keyPressDispatcher.bind(this));
    this.inputField.addEventListener('keyup', this.triggerSearch.bind(this));
  }

  triggerSearch(e) {
    if (this.searchTerm === this.inputField.value.trim()) {
      return;
    }
    if (typeof this.timeoutId === 'number') {
      clearTimeout(this.timeoutId);
    }
    if (this.inputField.value.trim() === '') {
      this.resultsDiv.innerHTML = '';
      this.fetchingResults = false;
      return;
    }
    if (this.fetchingResults === false) {
      this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
      this.fetchingResults = true;
    }
    this.searchTerm = this.inputField.value.trim();
    this.timeoutId = setTimeout(this.getResults.bind(this), 750);
  }

  getResults() {
    fetch(universityData.root_url + '/wp-json/university/v1/search?term=' + this.inputField.value.trim()).then(res => res.json()).then(res => {
      this.resultsDiv.innerHTML = `
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${res.generalInfo.length === 0 ?
              `<p>No general information matches that search</p>` :
              `<ul class="link-list min-list">
                ${res.generalInfo.map(item => `
                  <li><a href="${item.link}">${item.title}</a> ${item.type === 'post' ? `by ${item.author_name}` : ''}</li>
                `).join('')}
              </ul>`
            }
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${res.programs.length === 0 ?
              `<p>No programs match that search. <a href="${universityData.root_url}/programs">View all programs.</a></p>` :
              `<ul class="link-list min-list">
                ${res.programs.map(item => `<li><a href="${item.link}">${item.title}</a></li>`).join('')}
              </ul>`
            }
            <h2 class="search-overlay__section-title">Professors</h2>
            ${res.professors.length === 0 ?
              `<p>No professors match that search.</p>` :
              `<ul class="professor-cards">
                ${res.professors.map(item => `
                  <li class="professor-card__list-item">
                    <a class="professor-card" href="${item.link}">
                      <img class="professor-card__image" src="${item.thumbnail_url}">
                      <span class="professor-card__name">${item.title}</span>
                    </a>
                  </li>
                `).join('')}
              </ul>`
            }
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Campuses</h2>
            ${res.campuses.length === 0 ?
              `<p>No campuses match that search. <a href="${universityData.root_url}/campuses">View all campuses.</a></p>` :
              `<ul class="link-list min-list">
                ${res.campuses.map(item => `<li><a href="${item.link}">${item.title}</a></li>`).join('')}
              </ul>`
            }
            <h2 class="search-overlay__section-title">Events</h2>
            ${res.events.length === 0 ?
              `<p>No events match that search. <a href="${universityData.root_url}/events">View all events.</a></p>` :
              `<ul class="link-list min-list">
                ${res.events.map(item => `
                  <div class="event-summary">
                    <a class="event-summary__date t-center" href="${item.link}">
                      <span class="event-summary__month">${item.month}</span>
                      <span class="event-summary__day">${item.day}</span>
                    </a>
                    <div class="event-summary__content">
                      <h5 class="event-summary__title headline headline--tiny"><a href="${item.link}">${item.title}</a></h5>
                      <p>${item.description}<a href="${item.link}" class="nu gray"> Learn more</a></p>
                    </div>
                  </div>
                `).join('')}
              </ul>`
            }
          </div>
        </div>
      `;
      this.fetchingResults = false;
      this.timeoutId = undefined;
    });
  }

  openOverlay(e) {
    e.preventDefault();
    this.searchOverlay.classList.add('search-overlay--active');
    this.body.classList.add('body-no-scroll');
    setTimeout(() => this.inputField.focus(), 400);
    this.isOverlayOpen = true;
  }

  closeOverlay(e) {
    this.inputField.value = '';
    this.resultsDiv.innerHTML = '';
    this.searchOverlay.classList.remove('search-overlay--active');
    this.body.classList.remove('body-no-scroll');
    this.isOverlayOpen = false;
  }

  keyPressDispatcher(e) {
    // need to find way to see if other inputs/textareas have focus
    if (e.keyCode === 83 && this.isOverlayOpen === false && document.activeElement.tagName != "INPUT" && document.activeElement.tagName != "TEXTAREA") {
      this.openOverlay(e);
    }
    if (e.keyCode === 27 && this.isOverlayOpen === true) {
      this.closeOverlay();
    }
  }
}

export default Search
