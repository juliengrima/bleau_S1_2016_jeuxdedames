git status
read -r -p "Fichiers ok ? [N/y] \n" response
case $response in
    [yY][eE][sS]|[yY]) 
        git add .
        ;;
    *)
        echo 'Vérifie \n'
        ;;
esac


git commit

read -r -p "On push ? [N/y] \n" response
case $response in
    [yY][eE][sS]|[yY]) 
		branch=$(git rev-parse --symbolic-full-name --abbrev-ref HEAD)
        git push origin "$branch"
        ;;
    *)
        echo 'ok \n'
        ;;
esac