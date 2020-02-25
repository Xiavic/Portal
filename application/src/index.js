import $ from "jquery";
import './scss/global.scss';
import logoImg from './images/banner.png';
import xiavicBadgeImg from './images/xiavic_badge.png';
import sleipnirmg from './images/sleipnir.png';


$('.landing > header > .banner > #logo').attr('src', logoImg);
$('.landing > .introduction #xiavic-badge').attr('src', xiavicBadgeImg);
$('.sleipnir').attr('src', sleipnirmg);
