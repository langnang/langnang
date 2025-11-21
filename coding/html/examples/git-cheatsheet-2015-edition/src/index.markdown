<h1>Git Cheatsheet</h1>

  
Command              	| Description
-----------------------	| ---------------------------------
`git init`         			| initialise git
`git status` 						|	see what the current state of our project
`git add filename.ext`	|	add new file to the project to track (staging area)
`git add '*.js'`				|	add all JS files to the staging area
`git rm '*.js'`				|	Remove all JS files to the staging area
`git commit -m "Added initial files"` | Store the changes to the repository
`git remote add origin <https://github.com/freddielore/demo.git>` | add a remote repository
`git push -u origin master` | Push commits to remote origin repo. The name of our remote is origin and the default local branch name is master. The -u tells Git to remember the parameters, so that next time we can simply run git push and Git will know what to do. Go ahead and push it
`git pull origin master` | check for changes on GitHub repository and pull down any new changes
`git diff HEAD` | usually after pull requests, see the differces/new changes
`git diff --staged` | See differences/changes on your staging area
`git reset <octocat.txt>` | Unstaging some file
`git checkout -- octocat.txt` | git reset did a great job of unstaging octodog.txt, but you'll notice that he's still there. He's just not staged anymore. It would be great if we could go back to how things were before octodog came around and ruined the party. Files can be changed back to how they were at the last commit by using the command: git checkout -- < file >. Go ahead and get rid of all the changes since the last commit for octocat.txt
`git branch clean_up ` | When developers are working on a feature or bug they'll often create a copy (aka. branch) of their code they can make separate commits to. Then when they're done they can merge this branch back into their main master branch. We want to remove all these pesky octocats, so let's create a branch called ```clean_up```, where we will do all the work
`git branch` | display active branches
`git checkout <branch_name>` | Switch between branches
`git merge <branche_name>` | Alrighty, the moment has come when you have to merge your changes from the `clean_up` branch into the master branch. Take a deep breath, it's not that scary. We're already on the master branch, so we just need to tell Git to merge the `clean_up` branch into it
`git branch -d <branch_name>` | delete an unused branch


<ul class="stages">
  <li class="stages__item">
    <span class="stages__item-name">Initial state</span>
    <span class="stages__item-next">Modifications</span>
  </li>
  
  <li class="stages__item">
    <span class="stages__item-name">Working directory</span>
    <span class="stages__item-prev"><code>git checkout -- &lt;file&gt;</code></span>
    <span class="stages__item-next"><code>git add/rm &lt;file&gt;</code></span>
  </li>
  
  <li class="stages__item">
    <span class="stages__item-name">Index</span>
    <span class="stages__item-prev"><code>git reset HEAD &lt;file&gt;</code></span>
    <span class="stages__item-next"><code>git commit -m "&lt;message&gt;"</code></span>
  </li>
  
  <li class="stages__item">
    <span class="stages__item-name">HEAD</span>
    <span class="stages__item-prev"><code>git reset --soft HEAD~1</code></span>
    <span class="stages__item-next"><code>git push (origin &lt;branch&gt;)</code></span>
  </li>
  
  <li class="stages__item">
    <span class="stages__item-name">Remote repository</span>
    <span class="stages__item-prev">Ain't gonna be easy...</span>
  </li>
</ul>


