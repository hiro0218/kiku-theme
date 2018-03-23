import 'prismjs/prism';

// components
import 'prismjs/components/prism-markup';
import 'prismjs/components/prism-css';
import 'prismjs/components/prism-clike';
import 'prismjs/components/prism-javascript';
import 'prismjs/components/prism-bash';
import 'prismjs/components/prism-c';
import 'prismjs/components/prism-csharp';
import 'prismjs/components/prism-cpp';
import 'prismjs/components/prism-css-extras';
import 'prismjs/components/prism-java';
import 'prismjs/components/prism-json';
import 'prismjs/components/prism-less';
import 'prismjs/components/prism-markdown';
import 'prismjs/components/prism-objectivec';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-php-extras';
import 'prismjs/components/prism-powershell';
import 'prismjs/components/prism-scss';
import 'prismjs/components/prism-sql';
import 'prismjs/components/prism-swift';

// plugins
import 'prismjs/plugins/command-line/prism-command-line';
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/plugins/remove-initial-line-feed/prism-remove-initial-line-feed';
// prism-toolbar
import 'prismjs/plugins/toolbar/prism-toolbar';
import 'prismjs/plugins/show-language/prism-show-language';

// config
if (window.Prism) {
  document.removeEventListener('DOMContentLoaded', Prism.highlightAll);
}
