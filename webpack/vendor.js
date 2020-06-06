import 'popper.js';
import 'jquery';
import 'bootstrap';
import 'js-cookie';

// loading FontAwesome like this reduces page loads by 1 MB :scream_cat:
import { dom, library } from '@fortawesome/fontawesome-svg-core';
import { faBan, faBalanceScale, faBars, faCommentDots, faEnvelope, faHandshake, faHome, faPaperPlane, faPassport, faPencilAlt, faUser } from '@fortawesome/free-solid-svg-icons';
import { faFacebook, faInstagram, faWhatsapp, faYoutube } from '@fortawesome/free-brands-svg-icons';

library.add(faBalanceScale);
library.add(faBan);
library.add(faBars);
library.add(faCommentDots);
library.add(faEnvelope);
library.add(faFacebook);
library.add(faHandshake);
library.add(faHome);
library.add(faInstagram);
library.add(faPaperPlane);
library.add(faPassport);
library.add(faPencilAlt);
library.add(faUser);
library.add(faWhatsapp);
library.add(faYoutube);
dom.watch();