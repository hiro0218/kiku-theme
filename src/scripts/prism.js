import 'prismjs/prism';
import loadLanguages from 'prismjs/components/index';

// components
loadLanguages([
  'markup',
  'css',
  'clike',
  'javascript',
  'bash',
  'c',
  'csharp',
  'cpp',
  'css-extras',
  'java',
  'json',
  'less',
  'markdown',
  'objectivec',
  'php',
  'php-extras',
  'powershell',
  'scss',
  'sql',
  'swift',
]);

// plugins
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/plugins/remove-initial-line-feed/prism-remove-initial-line-feed';
// prism-toolbar
import 'prismjs/plugins/toolbar/prism-toolbar';
import 'prismjs/plugins/show-language/prism-show-language';

// config
if (window.Prism) {
  document.removeEventListener('DOMContentLoaded', Prism.highlightAll);
}
