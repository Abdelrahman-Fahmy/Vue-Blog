<template>
    <div>
        <h2>Articles</h2>
        <form @submit.prevent="addArticle" class="mb-4">
            <div class="form-group">
                <input type="text " class="form-control" placeholder="title" v-model="article.title" >
               
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="body" v-model="article.body"></textarea>
                
            </div>
            
            <button class="btn btn-light btn-block" type="submit">save</button>
        </form>
        <div class="card card-body mb-4" v-for="article in articles" v-bind:key="article.id">
            <h3>{{article.title}}</h3>
            <p>{{article.body}}</p>
            

            <hr>

            <button @click="editArticle(article)" class="btn btn-warning mb-3">edit</button>
            <button @click="deleteArticle(article.id)" class="btn btn-danger">delete</button>
        </div>

 
    </div>    
</template>

<script>
    export default {
        mounted() { 
            console.log('Component mounted.');   
               
        }
,
        data() {

            return {
                articles : [],
                article : {
                    id : '',
                    title : '',
                    body : ''
                },
                article_id: '',
                edit : false
                
            }

        }
,
        created(){
               this.fetchArticles(); 
        }
,
        methods: {
            fetchArticles(){
                fetch('api/articles').then(res => res.json())
                .then(res => {
                   
                    this.articles = res ;
                     console.log(res);
                })
            }
,
            deleteArticle(id){
                console.log(id);
                if(confirm('are you sure ?')){
                    fetch(`api/article/${id}`,{
                        method:'delete'
                        })
                        
                    .then(data => {
                        console.log(data);
                        this.fetchArticles();
                    }).catch(err => console.log(err));
        
                }

            }
            ,
            
            addArticle(){
                if(this.edit === false){
                    
                    fetch('api/article',{
                        method:'post',
                        body:JSON.stringify(this.article),
                        headers:{
                            'content-type':'application/json'
                        }
                        })
                        .then(res => res.json())
                        .then(data => {
                           
                            this.article.title='';
                            this.article.body='';
                            alert('article added');
                            this.fetchArticles();
                        });
                }
                else{

                     fetch('api/article',{
                        method:'put',
                        body:JSON.stringify(this.article),
                        headers:{
                            'content-type':'application/json'
                        }
                        })
                        .then(res => res.json())
                        .then(data => {
                           this.edit=false;
                            this.article.title='';
                            this.article.body='';
                            alert('article edited');
                            this.fetchArticles();
                        });

                }
            }
            ,
            editArticle(article)
            {
                this.edit=true;
                this.article.id=article.id;
                this.article.article_id=article.id;
                this.article.body=article.body;
                this.article.title=article.title;
               console.log(this.edit);
            }
        }
    }
</script>