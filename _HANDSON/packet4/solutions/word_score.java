import java.io.File;
import java.util.Scanner;

public class word_score
{
    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("word_score.dat"));

        while(fromFile.hasNextLine())
        {
            String bestWord=null;
            int bestScore = -1;
            String words[] = fromFile.nextLine().split(" ");
            for(String word:words) {
                String lowerWord=word.toLowerCase();
                int score = lowerWord.length() / 2;
                for (char c : lowerWord.toCharArray()) {
                    if (c == 'a' || c == 'e' || c == 'i' || c == 'o' || c == 'u')
                        score += 1;
                    else {
                        if (c == 'q' || c == 'x')
                            score += 3;
                        else if (c == 'z')
                            score += 2;
                    }
                    if(bestScore<score)
                    {
                        bestScore=score;
                        bestWord=word;
                    }
                }

            }
            System.out.println(bestWord + " - " + bestScore);
        }
    }
}
