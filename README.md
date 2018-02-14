# myblog_app

<h1>Description: Blog in php/mysql for multiple bloggers.</h1>

<h2>Functions:</h2>
<p>Each blog has a titel, a header image, a categorie, an excerpt and an author.</ br>
Each blogger has an account with his/her name, username and email.</ br>
You can select blogs on authors name and on category.</ br>
All bloggers can create new categories on their account page.</ br>
Bloggers can login (session).</ br>
Upon login, more buttons appear: 
    <ul>
  <li>ACCOUNT to view your settings and create or delete categories</li>
    <li>MANAGE BLOGS to     
        <ul>
            <li>edit a blog</li>
            <li>delete a blog</li>
            <li>look at the comments per blog</li>
        </ul>
     </li>
  <li>UPLOAD BLOG: to upload a new blog with an img and categories</li>
  <li>LOGOUT: to end the session</li>
  </ul>
Upon login, the page to show an individual blog is also extended. <br />
If you are the author of the blog, you will see new options popping up.<br />
You can
    <ul>
      <li>delete a comment</li>
      <li>close the blog for commenting</li>
    </ul>
If you close the blog for commenting, the comment option for readers will be invisible and no new comments can be added to the blog.
</p>

<h2>Content of application:</h2>
<p>Homepage displays excerpts of recent blogs that link to the actual blog.</ br>
Page to read one blog.</ br>
Page to login blogger.</ br>
Personal accountpage for the blogger.</ br>
Page to manage the comments of your blogs<br />
Upload a page.</ br>
Edit a page.</ br>
Delete a page.</ br>

<h2>Text Expander</h2>
<p>When entering your blog content with the upload-a-new-blog-form, a feature is activated to extend certain text to full words and centences. So far, these shortcuts are operational:</p>
 <ul>
        <li>"cg" : "CodeGorilla"</li>
        <li>"vrg" : "Vriendelijke groeten"</li>
    <li>"hrt" : "hartelijke groeten"</li>
    <li>"esm" : "Esmeralda Tijhoff"</li>
    <li>"gea" : "geachte heer/mevrouw"</li>
    <li>"gro" : "Groningen"</li>
    <li>"www.es" : "http://www.esmeraldatijhoff.nl"</li>
    <li>"wwww.wij" : "http://wijzijncodegorilla.nl/esmeraldatijhoff"</li>
</ul>

<h2>Layout</h2> 
<p>leftsided menu to select by author <br />
leftsided menu to select by categories without refresh<br />
external css file for layout.<br />
external php file for all php functions<br />
external connection file for database <br />
external js files to handle AJAX calls and jQuery<br />
folder to upload images to
    </p>


<h2>Resources</h2>
<p>Checklist and progress recorded on trello: https://trello.com/b/IN4NqNiT<br />
Demo of this blog on www.wijzijncodegorilla.nl/esmeraldatijhoff/blog/<br />
* Please login using username PietjeBel and password = password2  *
    </p>

<h2>Tools</h2>
<p>PHP using PDO<br />
MySQL database<br />
jQuery<br />
AJAX<br />
CSS3<br />
HTML5</p>

