import 'popper.js';
import 'jquery';
import 'bootstrap';
import 'js-cookie';
import 'validate.js';

// loading FontAwesome like this reduces page loads by 1 MB :scream_cat:
import { dom, library } from '@fortawesome/fontawesome-svg-core';
import { faBan, faBalanceScale, faBars, faEnvelope, faHandshake, faPaperPlane, faPassport, faPencilAlt, faUser } from '@fortawesome/free-solid-svg-icons';
library.add(faBalanceScale);
library.add(faBan);
library.add(faBars);
library.add(faEnvelope);
library.add(faHandshake);
library.add(faPaperPlane);
library.add(faPassport);
library.add(faPencilAlt);
library.add(faUser);
dom.watch();