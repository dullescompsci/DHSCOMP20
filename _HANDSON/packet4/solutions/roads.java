import java.awt.*;
import java.util.*;
import java.io.*;
public class roads
{
    private static char[][] house;
    private static boolean[][] visited;

    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("roads.dat"));

        while(fromFile.hasNextLine()) {
            visited = new boolean[10][10];
            house = new char[10][10];
            int startRow = 0, startCol = 0;

            for (int row = 0; row < house.length; row++) {
                String s = fromFile.nextLine();

                for (int col = 0; col < house[0].length; col++) {
                    house[row][col] = s.charAt(col);
                    if (house[row][col] == '*') {
                        startRow = row;
                        startCol = col;
                    }
                }
            }

            markVisited(startCol, startRow);

            System.out.println((allVisited())?"Accept":"Reject");

            if(fromFile.hasNextLine())
                fromFile.nextLine();
        }

    }

    public static void markVisited(int col,int row)
    {
        if(row < 0 || row >=visited.length ||col < 0 || col >=visited[0].length
                || visited[row][col] || house[row][col]=='I' )
            return;

        visited[row][col]=true;
        markVisited(col+1, row);
        markVisited(col-1, row);
        markVisited(col, row+1);
        markVisited(col, row-1);
    }

    public static boolean allVisited()
    {
        boolean allVisited = true;

        for(int row = 0; row< house.length; row++)
        {
            for(int col = 0; col< house[0].length; col++)
            {
                if(house[row][col]=='*' && !visited[row][col])
                    allVisited=false;
            }
        }
        return allVisited;
    }
}