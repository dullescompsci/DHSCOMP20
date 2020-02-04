import java.awt.*;
import java.util.*;
import java.io.*;

public class point_collection
{
    private static char[][] level;
    private static int[][] points;

    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("point_collection.dat"));

        while(fromFile.hasNextLine())
        {
            int numMoves = Integer.parseInt(fromFile.nextLine());
            level = new char[8][8];
            points = new int[8][8];
            int startCol=0, startRow=0;

            for(int row = 0; row< level.length; row++)
            {
                String s = fromFile.nextLine();

                for(int col = 0; col< level[0].length; col++)
                {
                    level[row][col] = s.charAt(col);
                    points[row][col] = 0;
                    if(level[row][col]=='S')
                    {
                        startRow=row;
                        startCol=col;
                    }
                    if(level[row][col] >='1' && level[row][col]<='9')
                        points[row][col] = level[row][col]-'0';
                }
            }

            ArrayList<Point> path = new ArrayList<>();
            path.add(new Point(startCol,startRow));
            int maxScore = findMax(path,numMoves);

            System.out.println(maxScore);
        }
    }

    public static int findMax(ArrayList<Point> path, int numMoves)
    {
        if(path.size()==numMoves+1)
        {
            return computeScore(path);
        }
        else
        {
            int leftScore=0,rightScore=0,upScore=0,downScore=0;

            int r = (int) path.get(path.size()-1).getY();
            int c = (int) path.get(path.size()-1).getX();

            if(r-1>=0 && level[r-1][c]!='W')
            {
                ArrayList<Point> clone = (ArrayList<Point>) path.clone();
                clone.add(new Point(c,r-1));
                upScore = findMax(clone,numMoves);
            }
            if(c-1>=0 && level[r][c-1]!='W')
            {
                ArrayList<Point> clone = (ArrayList<Point>) path.clone();
                clone.add(new Point(c-1,r));
                leftScore = findMax(clone,numMoves);
            }
            if(r+1<points.length && level[r+1][c]!='W')
            {
                ArrayList<Point> clone = (ArrayList<Point>) path.clone();
                clone.add(new Point(c,r+1));
                downScore = findMax(clone,numMoves);
            }
            if(c+1<points[0].length && level[r][c+1]!='W')
            {
                ArrayList<Point> clone = (ArrayList<Point>) path.clone();
                clone.add(new Point(c+1,r));
                rightScore = findMax(clone,numMoves);
            }
            return Math.max(leftScore,Math.max(rightScore,Math.max(upScore,downScore)));
        }
    }


    public static int computeScore(ArrayList<Point> path)
    {

        int score = 0;
        while(path.size() > 0)
        {
            Point p = path.get(0);
            score+=points[(int)p.getY()][(int)p.getX()];
            while(path.remove(p));
        }

        return score;
    }
}