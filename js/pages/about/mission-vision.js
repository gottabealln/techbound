
(() => {
    const section = document.querySelector('#mission-vision');

    if (!section) return;

    const tabs = Array.from(section.querySelectorAll('.mv-tab'));
    const panel = section.querySelector('#mv-panel');

    const content = {
        mission: {
            number: '01',
            label: 'WHAT WE DO',
            title: 'Our Mission',
            text: 'To help businesses grow online by delivering result-driven digital marketing, creative design and reliable web solutions that attract quality leads and build lasting brands.',
            caption: 'STRATEGY. CREATIVITY. GROWTH.',
            icon: 'target'
        },

        vision: {
            number: '02',
            label: 'WHERE WE ARE GOING',
            title: 'Our Vision',
            text: "To become Kerala's most trusted digital marketing agency, helping businesses reach their full potential through smart strategy, creative thinking and technology.",
            caption: 'TRUST. INNOVATION. IMPACT.',
            icon: 'vision'
        },

        values: {
            number: '03',
            label: 'WHAT WE BELIEVE IN',
            title: 'Our Values',
            text: 'We believe in transparency, meaningful collaboration, creative problem-solving and measurable results. Every strategy should serve our clients’ goals and build lasting partnerships.',
            caption: 'INTEGRITY. COLLABORATION. RESULTS.',
            icon: 'values'
        }
    };

    const icons = {
        target: `
            <circle cx="12" cy="12" r="9"></circle>
            <circle cx="12" cy="12" r="5"></circle>
            <circle cx="12" cy="12" r="1"></circle>
        `,
        vision: `
            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `,
        values: `
            <path d="m12 3 8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7z"></path>
            <path d="m9 12 2 2 4-4"></path>
        `
    };

    function activateTab(tab, animate = true) {
        const item = content[tab.dataset.tab];

        if (!item) return;

        tabs.forEach(button => {
            const active = button === tab;

            button.classList.toggle('is-active', active);
            button.setAttribute('aria-selected', String(active));
            button.tabIndex = active ? 0 : -1;
        });

        panel.setAttribute('aria-labelledby', tab.id);

        if (animate) {
            panel.classList.remove('is-changing');

            // Restart the CSS transition animation.
            void panel.offsetWidth;

            panel.classList.add('is-changing');
        }

        panel.querySelector('.mv-card-icon svg').innerHTML =
            icons[item.icon];

        panel.querySelector('.mv-card-label').textContent =
            `${item.number} / ${item.label}`;

        panel.querySelector('.mv-card-title').textContent =
            item.title;

        panel.querySelector('.mv-card-text').textContent =
            item.text;

        panel.querySelector('.mv-card-caption').textContent =
            item.caption;
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            activateTab(tab);
        });

        tab.addEventListener('keydown', event => {
            let nextIndex = index;

            if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
                nextIndex = (index + 1) % tabs.length;
            } else if (
                event.key === 'ArrowUp' ||
                event.key === 'ArrowLeft'
            ) {
                nextIndex = (index - 1 + tabs.length) % tabs.length;
            } else if (event.key === 'Home') {
                nextIndex = 0;
            } else if (event.key === 'End') {
                nextIndex = tabs.length - 1;
            } else {
                return;
            }

            event.preventDefault();
            tabs[nextIndex].focus();
            activateTab(tabs[nextIndex]);
        });
    });

    // Initialize the first tab without an animation.
    activateTab(tabs[0], false);
})();
