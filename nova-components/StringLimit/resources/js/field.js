import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-string-limit', IndexField)
  app.component('detail-string-limit', DetailField)
  app.component('form-string-limit', FormField)
})
